<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SwimProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\SwimPrograms\IndexCollection;

class SwimProgramController extends Controller
{
    /**
     * This PHP function retrieves swim programs from cache and returns them as a JSON response,
     * handling errors appropriately.
     *
     * @return JsonResponse A `JsonResponse` is being returned. If the `` collection is empty,
     * a JSON response with a message indicating "Resource not found" and a status code of 404 will be
     * returned. If an error occurs during the process, a JSON response with a message indicating
     * "Error list swim programs" and a status code of 500 will be returned. Otherwise, a JSON response
     * with the
     */
    public function __invoke(): JsonResponse
    {
        try {

            $programs = Cache::remember('programs', now()->addMinutes(10), function () {
                return SwimProgram::with(['swimCategories.skills'])->orderBy('id', 'DESC')->get();
            });

            if($programs->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }
                
            return response()->json(new IndexCollection($programs), 200);

        } catch(\Throwable $e) {

            Log::error('Error list swim programs: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error list swim programs',
            ], 500);
        }
    }
}
