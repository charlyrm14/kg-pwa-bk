<?php

namespace App\Http\Controllers;

use App\Http\Requests\Content\{
    StoreContentRequest
};
use App\Http\Resources\Content\{
    NewContentResource
};
use App\Services\Content\ContentManager;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function __construct(
        protected ContentManager $manager
    ){}

    /**
     * Store a newly event created resource in storage.
     * 
     * @param StoreContentRequest request The validated request object containing content data.
     * @return JsonResponse A JSON response indicating success or failure of user creation.
     */
    public function store(StoreContentRequest $request)
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
