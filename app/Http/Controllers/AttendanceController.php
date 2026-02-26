<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use DomainException;
use App\Domain\Schedules\Services\ResolveUserScheduleService;
use App\Models\{
    AttendanceStatus,
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
use Illuminate\Support\Facades\Cache;
use App\DTOs\Attendances\AssignAttendanceDTO;

class AttendanceController extends Controller
{
    public function __construct(
        private ResolveUserScheduleService $scheduleService
    )
    {}
    /**
     * Retrieve the list of attendance statuses.
     *
     * This endpoint returns a cached collection of attendance statuses used
     * to assign or display user attendance records. The data is cached to
     * improve performance since attendance statuses are static and rarely change.
     *
     * Cached fields:
     * - id
     * - name
     * - description
     *
     * Cache key: attendance_statuses
     *
     * @return JsonResponse
     *
     */
    public function attendanceStatuses(): JsonResponse
    {
        try {
            
            $statuses =  Cache::rememberForever('attendance_statuses', function () {
                return AttendanceStatus::select('id', 'name', 'description')->get();
            });

            return response()->json([
                'data' => $statuses
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get attendances statuses: " . $e->getMessage());

            return response()->json(["error" => 'Error to get attendances statuses'], 500);
        }
    }

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
     * This PHP function assigns attendance for a user and handles any exceptions that may occur during
     * the process.
     *
     * @param AssignAttendanceRequest request The `assignAttendance` function takes two parameters:
     * @param User user The `assignAttendance` function you provided seems to handle assigning
     * attendance for a user based on the given `AssignAttendanceRequest` and `User` parameters.
     *
     * @return JsonResponse A `JsonResponse` is being returned. If the assignment of user attendance is
     * successful, a JSON response with a success message and the assigned attendance data in the
     * `AssignAttendanceResource` format is returned with a status code of 201 (Created). If a
     * `DomainException` is caught during the process, a JSON response with the exception message and a
     * status code of 422 (Unprocessable Entity
     */
    public function assignAttendance(AssignAttendanceRequest $request, User $user): JsonResponse
    {
        try {

            $dto = AssignAttendanceDTO::fromArray($request->validated());
            
            $schedule = $this->scheduleService->handle($user->id, $dto->attendanceDate);
            
            $attendance = UserAttendance::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'user_schedule_id' => $schedule->id,
                    'attendance_date' => $dto->attendanceDate ?? today()
                ], [ 'attendance_status_id' => $dto->attendanceStatusId]
            );

            $attendance->load('attendanceStatus', 'userSchedule.day', 'user');
            
            return response()->json([
                'message' => 'User attendance assigned successfully',
                'data' => new AssignAttendanceResource($attendance)
            ], 201);

        } catch (DomainException $e) {

            return response()->json(['message' => $e->getMessage()], 422);

        } catch (\Throwable $e) {

            Log::error("Error to assign user attendance: " . $e->getMessage());

            return response()->json(["error" => 'Error to assign user attendance'], 500);
        }
    }
}
