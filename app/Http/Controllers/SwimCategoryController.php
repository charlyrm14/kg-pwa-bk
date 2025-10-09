<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SwimCategory;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SwimCategory\SwimCategoryCollection;
use Illuminate\Support\Facades\Log;

class SwimCategoryController extends Controller
{
    /**
     * Display a swim categories list with associated skills and returns a JSON response,
     * 
     * @return JsonResponse A JSON response is being returned. If the swim categories collection is
     * empty, a 404 status code with a message 'Resources not found' is returned. If there is an error
     * during the process, a 500 status code with a message 'Error list swim categories' is returned.
     * Otherwise, a 200 status code with the swim categories collection data is returned.
     */
    public function index(): JsonResponse
    {
        try {
            
            $swimCategories = SwimCategory::with('categorySkills.skill')->get();

            if($swimCategories->isEmpty()) {
                return response()->json(['message' => 'Resources not found'], 404);
            }
            
            return response()->json(new SwimCategoryCollection($swimCategories), 200);

        } catch(\Throwable $e) {

            Log::error('Error list swim categories: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error list swim categories',
            ], 500);
        }
    }
}
