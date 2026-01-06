<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    User,
    UserSchedule
};
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Schedule\{
    ShowUserScheduleResource
};
use App\Http\Requests\Schedule\AssignScheduleRequest;

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
    public function userSchedule(Request $request, ?string $uuid = null): JsonResponse
    {
        try {

            $user = UserService::resolveUser($request, $uuid, 'viewUserSchedule');
            
            return response()->json([
                'data' => new ShowUserScheduleResource($user->load('schedules.day'))
            ]);

        } catch (\Throwable $e) {

            Log::error("Error to get user schedule: " . $e->getMessage());

            return response()->json(["error" => 'Error to get user schedule'], 500);
        }
    }

    /**
     * Assigns a weekly schedule to a user.
     *
     * This endpoint associates one or more days with a user along with
     * their corresponding entry and departure times.
     * 
     * If the user already has assigned days, the schedule will be
     * synchronized using Laravel's `sync` method, updating existing
     * records and removing days that are no longer included in the request.
     *
     * The request expects:
     * - An array of day IDs.
     * - A single entry time applied to all selected days.
     * - A single departure time applied to all selected days.
     *
     * @param  AssignScheduleRequest  $request  Validated request containing days and schedule times.
     * @param  User                   $user     The user to whom the schedule will be assigned.
     *
     * @return JsonResponse
     *
     * @throws \Throwable If an unexpected error occurs during the schedule assignment.
     */
    public function assignSchedule(AssignScheduleRequest $request, User $user): JsonResponse
    {
        try {

            $days = collect($request->validated()['days'])
                ->mapWithKeys(function ($dayId) use ($request) {
                    return [
                        $dayId => [
                            'entry_time' => $request->validated()['entry_time'],
                            'departure_time' => $request->validated()['departure_time']
                        ]
                    ];
                });
            
            $user->days()->sync($days);
            
            return response()->json([
                'data' => 'Success'
            ], 201);

        } catch (\Throwable $e) {

            Log::error("Error to assign user schedule: " . $e->getMessage());

            return response()->json(["error" => 'Error to assign user schedule'], 500);
        }
    }
}
