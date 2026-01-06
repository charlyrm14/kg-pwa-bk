<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User\BirthdayUsersCollection;
use App\Services\Student\StudentProgressService;

class BirthdayController extends Controller
{
    public function __construct(
        protected StudentProgressService $studentService
    ){}

    /**
     * Retrieve and return a list of users whose birthday is today.
     *
     * @return JsonResponse a JSON response indicating success or failure of retrieving users by birthdate
     */
    public function __invoke(): JsonResponse
    {
        try {

            $users = User::birthdayToday();

            if($users->isEmpty()) {
                return response()->json(['message' => 'Results not found'], 404);
            }

            $users->map(function($user){
                $currentLevel = $this->studentService->currentLevelData($user);
                $user->current_level = $currentLevel['category_name'] ?? 'NO DEFINIDO'; 
            });

            return response()->json(new BirthdayUsersCollection($users), 200);

        } catch (\Throwable $e) {

            Log::error('Error to get users birthdays: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to get users birthdays',
            ], 500);
        }
    }
}
