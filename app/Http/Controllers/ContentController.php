<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    Content
};
use App\Http\Requests\Content\{
    StoreContentRequest
};
use App\Http\Resources\Content\{
    IndexCollection,
    NewContentResource
};
use App\Services\Content\ContentManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(
        protected ContentManager $manager
    ){}

    /**
     * The index function retrieves a list of content based on certain conditions and returns it as a
     * JSON response.
     * 
     * @param Request request The `index` function is a controller method that retrieves a list of
     * content based on certain conditions. Here's an explanation of the code:
     * 
     * @return JsonResponse A JSON response is being returned with a data key containing the result of
     * the IndexCollection transformation of the contents fetched from the database. If successful, the
     * response will have a status code of 200. If an error occurs during the process, a JSON response
     * with an error message and a status code of 500 will be returned.
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $query = Content::query();

            if(!($request->user() && $request->user()->role_id === 1)) {
                $query->where('content_status_id', 5);
            } 

            $contents = $query->with(['type', 'status', 'user', 'event'])->paginate(15);

            return response()->json([
                'data' => new IndexCollection($contents)
            ], 200);

        } catch(\Throwable $e) {

            Log::error('Error to get content list: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to get content list',
            ], 500);

        }
    }

    /**
     * Store a newly event created resource in storage.
     * 
     * @param StoreContentRequest request The validated request object containing content data.
     * @return JsonResponse A JSON response indicating success or failure of user creation.
     */
    public function store(StoreContentRequest $request): JsonResponse
    {
        try {
            
            $data = $request->validated() + [
                'type' => 'events',
                'content_type_id' => 2
            ];

            $content = $this->manager->handle($data);

            return response()->json([
                'message' => 'Content created successfully',
                'data' => new NewContentResource($content->load('type', 'status', 'user', 'event'))
            ], 201);

        } catch(\Throwable $e) {

            Log::error('Error creating event: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error creating event',
            ], 500);
        }
    }
}
