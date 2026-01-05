<?php

namespace App\Http\Controllers;

use App\Models\{
    Chat,
    User
};
use Illuminate\Http\{
    Request,
    JsonResponse
};
use Illuminate\Support\Facades\{
    DB,
    Log
};
use App\Http\Resources\Chat\NewChatResource;
use App\Http\Requests\Chat\StoreChatRequest;
use Illuminate\Support\Arr;

class ChatController extends Controller
{
    /**
     * The `store` function creates a new chat with participants and handles errors using transactions
     * in PHP.
     * 
     * @param StoreChatRequest request The `store` function you provided is responsible for creating a
     * new chat in your application. Let's break down the key steps in this function:
     * 
     * @return JsonResponse A JSON response is being returned. If the chat creation is successful, it
     * will return a JSON response with the newly created chat data in the 'data' key along with a
     * status code of 201 (Created). If there is an error during the chat creation process, it will
     * return a JSON response with an error message and a status code of 500 (Internal Server Error).
     */
    public function store(StoreChatRequest $request): JsonResponse
    {
        try {

            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
        
            DB::beginTransaction();

            $chat = Chat::updateOrCreate(
                [
                    'chat_type_id' => $request->validated()['chat_type_id'],
                    'created_by' => $user->id
                ], 
                [ 
                    'title' => $request->validated()['title'] ?? null
                ]
            );

            $chat->participants()->firstOrCreate(
                [ 'user_id' => $user->id ], 
                [ 'joined_at' => now()]
            );

            if($chat->chatType->name === 'AI_ASSISTANT') { // AI_ASSISTANT

                $aiUser = User::where('email', config('app.ai_email'))->first();
                
                if(!$aiUser) {
                    return response()->json(['message' => 'AI User not found'], 404);
                }

                $chat->participants()->firstOrCreate(
                    ['user_id' => $aiUser->id], 
                    ['joined_at' => now()]
                );
            }

            DB::commit();

            $chat->load('chatType', 'createdBy', 'participants.user');

            return response()->json([
                'data' => new NewChatResource($chat)
            ], 201);

        } catch(\Throwable $e) {

            DB::rollBack();

            Log::error('Error creating chat: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error creating chat',
            ], 500);

        }
    }
}
