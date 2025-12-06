<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Attendance\{
    AttendanceResource
};

class AttendanceController extends Controller
{
    /**
     * This PHP function retrieves the attendance data for a user in the current month and returns it
     * as a JSON response.
     * 
     * @param Request request The `attendancesByUser` function is designed to retrieve attendance data
     * for a specific user for the current month. Here's a breakdown of the code:
     * 
     * @return JsonResponse A JSON response is being returned. If the user is found, it will return the
     * user's attendances for the current month in JSON format with a status code of 200. If there is
     * an error, it will return a JSON response with an error message and a status code of 500.
     */
    public function attendancesByUser(Request $request): JsonResponse
    {
        try {

            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->load(['attendancesCurrentMonth']);

            return response()->json([
                'data' => new AttendanceResource($user)
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get user attendances: " . $e->getMessage());

            return response()->json(["error" => 'Error to get user attendances'], 500);
        }
    }
}
