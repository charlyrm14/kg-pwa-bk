<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SwimCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\SwimCategories\IndexCollection;

class SwimCategoryController extends Controller
{
    /**
     * This PHP function retrieves swim categories from cache and returns them as a JSON response,
     * handling errors appropriately.
     *
     * @return JsonResponse A `JsonResponse` is being returned. If the `` collection is
     * empty, a JSON response with a message "Resource not found" and status code 404 is returned. If
     * there is an error during the process, a JSON response with a message "Error list swim
     * categories" and status code 500 is returned. Otherwise, a JSON response with the collection of
     * swim categories in the `
     */
    public function __invoke(): JsonResponse
    {
        try {

            $categories = Cache::remember('categories', now()->addMinutes(10), function () {
                return SwimCategory::with(['skills'])->orderBy('id', 'DESC')->get();
            });

            if($categories->isEmpty()) {
                return response()->json(['Resource not found'], 404);
            }
                        
            return response()->json(new IndexCollection($categories), 200);

        } catch(\Throwable $e) {

            Log::error('Error list swim categories: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error list swim categories',
            ], 500);
        }
    }
}
