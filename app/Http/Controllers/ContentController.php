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
    NewContentResource,
    DetailContentResource
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

    /**
     * This PHP function retrieves detailed information about a content item based on its slug, with
     * access control and error handling.
     * 
     * @param string slug The `slug` parameter in the `detail` function is a string that represents a
     * unique identifier for the content you want to retrieve details for. It is used to query the
     * database for the specific content based on its slug value.
     * @param Request request The `detail` function is responsible for retrieving the details of a
     * content item based on its slug. Here's a breakdown of the function and its parameters:
     * 
     * @return JsonResponse A JSON response is being returned. If the content is found and the
     * conditions are met, it will return a JSON response with the data of the content using the
     * DetailContentResource. If the content is not found or the conditions are not met, it will return
     * a JSON response with an appropriate error message and status code.
     */
    public function detail(string $slug, Request $request): JsonResponse
    {
        try {

            $content = Content::with(['type', 'status', 'user', 'event'])->firstWhere('slug', $slug);

            if(!$content) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            if(!($request->user() && $request->user()->role_id === 1) && $content->content_status_id !== 5) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            return response()->json([
                'data' => new DetailContentResource($content)
            ], 200);
            
        } catch (\Throwable $e) {

            Log::error('Error to get content detail: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to get content detail',
            ], 500);
        }
    }
}
