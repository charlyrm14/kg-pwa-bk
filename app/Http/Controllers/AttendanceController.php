<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Attendance\{
    TodayAttendanceCollection,
    AttendanceResource
};
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;

class AttendanceController extends Controller
{
    /**
     * Get today's attendances.
     *
     * This endpoint retrieves a paginated list of users
     * who have classes scheduled for the current day.
     *
     * If no attendances are found, a 404 response is returned.
     * In case of unexpected errors, a 500 response is returned
     * and the error is logged.
     *
     * @return JsonResponse
     */
    public function todayAttendances(): JsonResponse
    {
        try {
            
            $attendances = UserSchedule::todayAttendances();

            if($attendances->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            return response()->json(new TodayAttendanceCollection($attendances), 200);

        } catch (\Throwable $e) {

            Log::error("Error to get today attendances: " . $e->getMessage());

            return response()->json(["error" => 'Error to get today attendances'], 500);
        }
    }

    /**
     * This PHP function retrieves the attendance data for a user in the current month and returns it
     * as a JSON response.
     * 
     * @param Request request The `monthlyHistory` function is designed to retrieve attendance data
     * for a specific user for the current month. Here's a breakdown of the code:
     * 
     * @return JsonResponse A JSON response is being returned. If the user is found, it will return the
     * user's attendances for the current month in JSON format with a status code of 200. If there is
     * an error, it will return a JSON response with an error message and a status code of 500.
     */
    public function monthlyHistory(Request $request, ?string $uuid = null): JsonResponse
    {
        try {

            $user = UserService::resolveUser($request, $uuid, 'viewMonthlyAttendances');
            
            $user->load(['attendancesCurrentMonth']);

            return response()->json([
                'data' => new AttendanceResource($user)
            ], 200);

        } catch (HttpResponseException $e) {

            Log::error("Error to get user attendances validation: " . $e->getMessage());
            throw $e;

        }  catch (\Throwable $e) {

            Log::error("Error to get user attendances: " . $e->getMessage());

            return response()->json(["error" => 'Error to get user attendances'], 500);
        }
    }
}
