<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RuntimeException;
use Illuminate\Http\JsonResponse;
use App\Domain\Media\MediaManager;
use App\DTOs\Media\MediaUploadDTO;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Resources\Media\StoreMediaResource;

class MediaController extends Controller
{
    public function __construct(
        private MediaManager $manager
    ){}

    /**
     * The `store` function in PHP handles the uploading of media files, logging any errors that occur
     * and returning a JSON response with the uploaded media data or an error message.
     * 
     * @param StoreMediaRequest request The `store` function in the code snippet is responsible for
     * handling the storage of media files. Let's break down the parameters and the flow of the
     * function:
     * 
     * @return JsonResponse A JSON response is being returned. If the file upload is successful, it
     * will return a JSON response with the uploaded media data under the 'data' key and a status code
     * of 200. If there is an error during the upload process, it will return a JSON response with an
     * error message under the 'error' key and a status code of 500.
     */
    public function store(StoreMediaRequest $request): JsonResponse
    {
        try {

            $fileDTOs = MediaUploadDTO::fromArray(
                $request->validated()['files'], 
                config('filesystems.media_disk'),
                $request->user()->id
            );
                    
            $media = $this->manager->upload($fileDTOs);
            
            return response()->json([
                'data' => StoreMediaResource::collection($media)
            ], 200);

        } catch (RuntimeException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        } catch (\Throwable $e) {
            
            Log::error("Store file error: " . $e->getMessage());
            
            return response()->json(["error" => 'Failed to upload file. Please try again later'], 500);
        }
    }
}
