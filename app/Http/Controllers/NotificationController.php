<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Notification\IndexCollection;

class NotificationController extends Controller
{
    /**
     * This PHP function retrieves notifications for a specific user and returns them in a paginated
     * JSON response.
     * 
     * @param Request request The `index` function is used to retrieve notifications for a specific
     * user. Here's a breakdown of the code:
     * 
     * @return JsonResponse A JSON response is being returned. If the `` collection is
     * empty, a 404 status code with a message 'Resource not found' is returned. If there is an error
     * during the process, a 500 status code with an error message 'Error to get notifications' is
     * returned. Otherwise, a 200 status code with the data in the form of an `IndexCollection` is
     * returned
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $notifications = UserNotification::query()
                ->where('user_id', $request->user()->id)
                ->with(['notification.notificationType'])
                ->orderByDesc('id')
                ->cursorPaginate(15);
            
            if($notifications->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }
            
            return response()->json([
                'data' => new IndexCollection($notifications)
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get notifications: " . $e->getMessage());

            return response()->json(["error" => 'Error to get notifications'], 500);
        }
    }

    /**
     * This PHP function marks a user notification as read and handles error logging.
     * 
     * @param Request request The `Request` parameter in the `markAsRead` function represents the HTTP
     * request that is being made to mark a notification as read. It contains all the data and
     * information sent by the client to the server.
     * @param UserNotification userNotification  is an instance of the
     * UserNotification model, representing a notification for a specific user. The function markAsRead
     * takes a Request object and a UserNotification object as parameters. The purpose of this function
     * is to mark a notification as read for the authenticated user.
     * 
     * @return a JSON response with a success message 'Notification mark as read' and a status code of
     * 200 if the notification is successfully marked as read. If there is a forbidden access due to
     * the user ID not matching, it returns a JSON response with a message 'Forbidden' and a status
     * code of 403. If the notification is already marked as read, it returns a JSON response
     */
    public function markAsRead(Request $request, UserNotification $userNotification)
    {
        try {

            if($request->user()->id !== $userNotification->user_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            if($userNotification->is_read) {
                return response()->json(['message' => 'Notification is already marked as read'], 422);
            }

            $userNotification->is_read = true;
            $userNotification->read_at = now();
            $userNotification->save();
            
            return response()->json([
                'message' => 'Notification mark as read',
                'data' => [
                    'id' => $userNotification->id,
                    'is_read' => (boolean) $userNotification->is_read,
                    'read_at' => Carbon::parse($userNotification->read_at)->format('Y-m-d H:i')
                ]
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to mark notification as read: " . $e->getMessage());

            return response()->json(["error" => 'Error to mark notification as read'], 500);
        }
    }
}
