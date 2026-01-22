<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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
}
