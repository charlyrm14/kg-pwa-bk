<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Chat,
    ChatMessage
};
use Illuminate\Http\Request;
use App\Http\Requests\Chat\StoreChatMessageRequest;
use Illuminate\Support\Facades\{
    DB,
    Log
};
use App\Services\AI\PromptsChatBuilderService;
use App\Services\API\AIService;
use App\Http\Resources\Chat\ChatMessageResource;

class ChatMessageController extends Controller
{
    public function __construct(
        protected PromptsChatBuilderService $promptsChatBuilderService
    )
    {}

    /**
     * The `store` function handles storing chat messages, generating AI responses, and managing
     * database transactions.
     * 
     * @param StoreChatMessageRequest request The `store` function you provided seems to handle storing
     * chat messages in a chat application. It first checks if the user exists, then retrieves an AI
     * user. It builds a payload with system and user messages, sends the payload to an AI service, and
     * creates chat messages for the user and AI assistant
     * @param Chat chat The `store` function you provided is responsible for storing a chat message in
     * a chat conversation between a user and an AI assistant. Let me explain the parameters:
     * 
     * @return The `store` function returns a JSON response with the data of the chat message that was
     * created, along with an HTTP status code of 201 (Created) if the process is successful. If an
     * error occurs during the process, it returns a JSON response with an error message and an HTTP
     * status code of 500 (Internal Server Error).
     */
    public function store(StoreChatMessageRequest $request, Chat $chat)
    {
        try {

            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $aiUser = User::ai();

            if(!$aiUser) {
                return response()->json(['message' => 'AI User not found'], 404);
            }

            $instructions = $this->promptsChatBuilderService->buildPrompt($request->validated()['message']);

            $payload = [
                [
                    'role' => 'system', 
                    'content' => $instructions,
                ],
                [
                    'role' => 'user', 
                    'content' => $request->validated()['message']
                ],
            ];

            $ai = AIService::apiAI($payload);
            
            if(is_null($ai)) {
                return response()->json([
                    'message' => 'Error to generate AI response',
                ], 500);
            }

            DB::beginTransaction();

            $chatMessage = $chat->messages()->create(
                [
                    'chat_id' => $chat->id,
                    'user_id' => $user->id,
                    'message' => $request->validated()['message'],
                    'sender_type_id' => 1 // USER
                ]
            );

            $chatResponse = $chat->messages()->create(
                [
                    'chat_id' => $chat->id,
                    'user_id' => $aiUser->id,
                    'message' => $ai['answer'],
                    'sender_type_id' => 2 // AI_ASSISTANT
                ]
            );

            DB::commit();

            $chatResponse->load('user');

            return response()->json([
                'data' => new ChatMessageResource($chatResponse)
            ], 201);

        } catch(\Throwable $e) {

            DB::rollBack();

            Log::error('Error to send message: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to send message',
            ], 500);

        }
    }
}
