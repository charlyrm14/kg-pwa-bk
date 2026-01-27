<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Push\StorePushNotificationRequest;

class PushNotificationController extends Controller
{
    /**
     * The function `store` handles storing push notification subscription details for a user in PHP.
     * 
     * @param StorePushNotificationRequest request The `store` function is used to store a push
     * notification subscription for a user. Here is an explanation of the parameters used in the
     * function:
     * 
     * @return JsonResponse A JSON response is being returned. If the push subscription is successfully
     * stored, a response with a status code of 201 and a message 'Subscription stored' is returned. If
     * an error occurs during the process, a response with a status code of 500 and a message 'Error
     * storing push subscription' is returned.
     */
    public function store(StorePushNotificationRequest $request): JsonResponse
    {
        try {

            $user = $request->user();

            $user->pushSubscriptions()->updateOrCreate(
                ['endpoint' => $request->validated()['endpoint']],
                [
                    'public_key' => $request->validated()['keys']['public_key'],
                    'auth_token' => $request->validated()['keys']['auth_token'],
                    'content_encoding' => 'aesgcm',
                ]
            );

            return response()->json([
                'message' => 'Subscription stored'
            ], 201);

        } catch(\Throwable $e) {

            Log::error('Error storing push subscription: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error storing push subscription',
            ], 500);
        }   
    }
}
