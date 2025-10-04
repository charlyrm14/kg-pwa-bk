<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{User};
use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserProfileRequest
};
use Illuminate\Support\Facades\{
    Log
};
use App\Http\Resources\User\{
    NewUserResource,
    UpdateUserProfileResource
};
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreUserRequest request The validated request object containing user data.
     * @return JsonResponse A JSON response indicating success or failure of user creation.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {

            $user = User::create($request->validated());
            
            return response()->json([
                'message' => 'User created successfully',
                'data' => new NewUserResource($user->load('role')),
            ], 201);

        } catch(\Throwable $e) {

            Log::error('Error creating user: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error creating user',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateUserProfileRequest request The validated request object containing profile data.
     * @param string uuid The UUID of the user whose profile is to be updated.
     * 
     * @return JsonResponse A JSON response indicating success or failure of user profile updated.
     */
    public function updateProfileInfo(UpdateUserProfileRequest $request, string $uuid): JsonResponse
    {
        try {

            $user = User::getByUuid($uuid);

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->profile()->updateOrCreate([], $request->validated());

            return response()->json([
                'message' => 'User profile updated successfully',
                'data' => new UpdateUserProfileResource($user->load('profile.gender'))
            ], 201);

        } catch(\Throwable $e) {

            Log::error('Error updating user profile info: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error updating user profile info',
            ], 500);
        }
    }
}
