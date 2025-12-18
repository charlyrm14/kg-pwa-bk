<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    User,
    Content
};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\Student\StudentProgressService;
use App\Http\Resources\UserOverview\IndexResource;

class UserOverviewController extends Controller
{
    public function __construct(
        protected StudentProgressService $studentService
    ){}

    /**
     * This PHP function retrieves user overview information and returns it as a JSON response.
     * 
     * @param Request request The code snippet you provided is a PHP function that handles a request
     * and returns a JSON response with user overview information. Here's a breakdown of what the code
     * does:
     * 
     * @return JsonResponse A JSON response containing user overview information is being returned. The
     * data includes the user's role, student progress, current level, next level, today's birthdays,
     * and the latest content event. If an error occurs during the process, a JSON response with an
     * error message is returned.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {

            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $event = Content::getLatestContentPublished(2);
            $user->last_event = $event ?? null;
            $user->load(['role', 'studentProgress']);

            $currentLevel = $this->studentService->currentLevelData($user);
            $nextLevel = $this->studentService->nextLevelData($user);
            
            $user->current_level = $currentLevel;
            $user->next_level = $nextLevel;
            $user->todays_birthdays = User::birthdayToday();

            return response()->json([
                'data' => new IndexResource($user)
            ], 200);

        } catch (\Throwable $e) {

            Log::error("Error to get user overview information: " . $e->getMessage());

            return response()->json(["error" => 'Error to get user overview information'], 500);
        }
    }
}
