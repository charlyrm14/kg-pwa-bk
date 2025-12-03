<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Http\Resources\Hobbies\IndexCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class HobbyController extends Controller
{
    /**
     * The function retrieves a list of hobbies and returns it as a JSON response, handling potential
     * errors along the way.
     * 
     * @return If the `` collection is not empty, a JSON response containing the hobbies data
     * in the `IndexCollection` format with a status code of 200 will be returned. If the ``
     * collection is empty, a JSON response with a message 'Not found' and a status code of 404 will be
     * returned. If an error occurs during the process, a JSON response with an
     */
    public function __invoke(): JsonResponse
    {
        try {
            
            $hobbies = Hobby::all();

            if($hobbies->isEmpty()) {
                return response()->json(['message' => 'Not found'], 404);
            }

            return response()->json(new IndexCollection($hobbies), 200);

        } catch (\Throwable $e) {

            Log::error("Error to get hobbies list: " . $e->getMessage());

            return response()->json(["error" => 'Error to get hobbies list'], 500);
        }
    }
}
