<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Hobby
};
use App\Http\Resources\User\{
    UpdateUserHobbiesResource
};
use App\Http\Requests\User\{
    UpdateUserHobbiesRequest
};
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Hobbies\IndexCollection;


class HobbyController extends Controller
{
    
    /**
     * The index function retrieves a list of hobbies and returns it as a JSON response, handling
     * potential errors along the way.
     * 
     * @return JsonResponse The `index` function is returning a JSON response. If the ``
     * collection is empty, it returns a 404 status code with a message 'Not found'. If there is an
     * error during the process, it logs the error message and returns a 500 status code with an error
     * message 'Error to get hobbies list'. Otherwise, it returns a 200 status code with a JSON
     * response
     */
    public function index(): JsonResponse
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

    /**
     * Update the hobbies on a specific user
     * 
     * @param UpdateUserHobbiesRequest request The validated request object containing hobbies data
     * @param string uuid The UUID of the user whose hobbies are updated
     * 
     * @return JsonResponse a JSON response indicating success or failure of user hobbies updated
     */
    public function syncHobbies(UpdateUserHobbiesRequest $request): JsonResponse
    {
        try {
            
            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $hobbies = $request->validated()['hobbies'];

            if(count($hobbies) > 8) {
                return response()->json(['message' => 'You cannot select more than 8 hobbies'], 403);
            }

            /**
             * Inserta los hobbies que esten dentro del request y elimina los que ya no están en la tabla
             */
            $user->hobbies()->sync($hobbies);
            
            return response()->json([
                'message' => 'User hobbies updated successfully',
                'data' => new UpdateUserHobbiesResource($user->load('hobbies'))
            ], 201);

        } catch (\Throwable $e) {
            
            Log::error('Error updating user hobbies: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error updating user hobbies',
            ], 500);
        }
    }
}
