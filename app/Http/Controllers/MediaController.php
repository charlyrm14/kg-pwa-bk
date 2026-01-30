<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Domain\Media\MediaManager;
use App\DTOs\Media\MediaUploadDTO;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Resources\Media\StoreMediaResource;
use App\Domain\Media\Services\MediaDeleteService;
use Illuminate\Http\Exceptions\HttpResponseException;

class MediaController extends Controller
{
    public function __construct(
        private MediaManager $manager,
        private MediaDeleteService $mediaDeleteService
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

    /**
     * Delete a media file and all its related variants.
     *
     * This endpoint validates that the media is allowed to be deleted
     * (not protected and owned by the authenticated user),
     * removes physical files from storage, cleans up empty directories,
     * and deletes database records inside a transaction.
     *
     * @param Request $request Incoming HTTP request.
     * @param Media   $media   Media model resolved by route-model binding.
     *
     * @return JsonResponse JSON response indicating success or failure.
     *
     * @throws HttpResponseException When business validation fails
     *                               (e.g. protected file or unauthorized user).
     */
    public function destroy(Request $request, Media $media): JsonResponse
    {
        try {

            $this->mediaDeleteService->delete($media);
            
            return response()->json([
                'message' => 'File successfully deleted'
            ], 200);

        } catch (HttpResponseException $e) {

            Log::error("Error deleting file validation: " . $e->getMessage());
            throw $e;

        } catch (\Throwable $e) {
            
            Log::error("Error deleting file: " . $e->getMessage());
            
            return response()->json(["error" => 'Error deleting file. Please try again later'], 500);
        }
    }
}
