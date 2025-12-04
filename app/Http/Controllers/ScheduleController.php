<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Schedule\{
    ShowUserScheduleResource
};

class ScheduleController extends Controller
{
    /**
     * This PHP function retrieves and returns a user's schedule as JSON response, handling errors and
     * logging any exceptions.
     * 
     * @param Request request The `userSchedule` function takes a `Request` object as a parameter. This
     * object is typically an instance of the `Illuminate\Http\Request` class in Laravel, which
     * represents an HTTP request coming into the application.
     * 
     * @return JsonResponse A JSON response is being returned. If the user is found, it will return the
     * user's schedule data in JSON format using the ShowUserScheduleResource. If the user is not
     * found, a 404 response with a message 'User not found' will be returned. If there is an error
     * during the process, a 500 response with an error message 'Error to get user schedule' will be
     */
    public function userSchedule(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json([
                'data' => new ShowUserScheduleResource($user->load('schedules.day'))
            ]);

        } catch (\Throwable $e) {

            Log::error("Error to get user schedule: " . $e->getMessage());

            return response()->json(["error" => 'Error to get user schedule'], 500);
        }
    }
}
