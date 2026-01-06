<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    User,
    UserSchedule,
    UserAttendance
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Attendance\{
    TodayAttendanceCollection,
    AttendanceResource,
    AssignAttendanceResource
};
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\Attendance\AssignAttendanceRequest;

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

    /**
     * Assign or update today's attendance status for a specific user.
     *
     * This endpoint creates or updates the attendance record for the authenticated
     * day schedule of the given user. If an attendance record already exists for
     * the user and their schedule of the current day, it will be updated with the
     * new attendance status. Otherwise, a new attendance record will be created.
     *
     * Business rules:
     * - A user can only have one attendance record per schedule per day.
     * - Attendance status is mutable and can be corrected by an administrator.
     *
     * @param  AssignAttendanceRequest  $request
     *         Validated request containing the attendance_status_id.
     *
     * @param  User  $user
     *         The user whose attendance is being assigned (route model binding).
     *
     * @return JsonResponse
     *         Returns a JSON response with:
     *         - 201: Attendance assigned or updated successfully.
     *         - 404: User has no schedule assigned for the current day.
     *         - 500: An unexpected server error occurred.
     *
     * @throws \Throwable
     *         If any unexpected error occurs during the process.
     */
    public function assignAttendance(AssignAttendanceRequest $request, User $user): JsonResponse
    {
        try {

            $schedule = $user->scheduleByDay()->first();

            if(!$schedule) {
                return response()->json(['message' => 'User has no schedules assigned'], 404);
            }

            $attendance = UserAttendance::updateOrCreate(
                ['user_id' => $user->id, 'user_schedule_id' => $schedule->id,],
                ['attendance_status_id' => $request->validated()['attendance_status_id']]
            ); 

            $attendance->load('attendanceStatus', 'userSchedule.day', 'user');
            
            return response()->json([
                'message' => 'User attendance assigned successfully',
                'data' => new AssignAttendanceResource($attendance)
            ], 201);

        } catch (\Throwable $e) {

            Log::error("Error to assign user attendance: " . $e->getMessage());

            return response()->json(["error" => 'Error to assign user attendance'], 500);
        }
    }
}
