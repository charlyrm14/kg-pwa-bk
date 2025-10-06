<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{
    User
};
use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserHobbiesRequest,
    UpdateUserInfoRequest,
    UpdateUserProfileRequest
};
use Illuminate\Support\Facades\{
    Log
};
use App\Http\Resources\User\{
    NewUserResource,
    UpdateUserHobbiesResource,
    UpdateUserInfoResource,
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
     * Update the basic information from a specific user in storage
     * 
     * @param UpdateUserInfoRequest request The validated request object containing information data.
     * @param string uuid The UUID of the user whose information is to be updated.
     * 
     * @return JsonResponse A JSON response indicating success or failure of user information updated.
     */
    public function update(UpdateUserInfoRequest $request, string $uuid)
    {
        try {

            $user = User::getByUuid($uuid);

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->update($request->validated());

            return response()->json([
                'message' => 'User information updated successfully',
                'data' => new UpdateUserInfoResource($user)
            ], 200);

        } catch(\Throwable $e) {

            Log::error('Error updating user basic info: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error updating user basic info',
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

    /**
     * Update the hobbies on a specific user
     * 
     * @param UpdateUserHobbiesRequest request The validated request object containing hobbies data
     * @param string uuid The UUID of the user whose hobbies are updated
     * 
     * @return JsonResponse a JSON response indicating success or failure of user hobbies updated
     */
    public function updateHobbies(UpdateUserHobbiesRequest $request, string $uuid): JsonResponse
    {
        try {
            
            $user = User::getByUuid($uuid);

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $hobbies = $request->validated()['hobbies'];

            if(count($hobbies) > 8) {
                return response()->json(['message' => 'You cannot select more than 8 hobbies'], 403);
            }

            /**
             * Inserta los hobbies que esten dentro del request y elimina los que ya no están en la tabla
             */
            $user->hobbies()->sync($hobbies);
            
            return response()->json([
                'message' => 'User hobbies updated successfully',
                'data' => new UpdateUserHobbiesResource($user->load('hobbies'))
            ], 201);

        } catch (\Throwable $e) {
            
            Log::error('Error updating user hobbies: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error updating user hobbies',
            ], 500);
        }
    }

    /**
     * Delete the specified user from storage
     * 
     * @param string uuid The UUID of the user whose hobbies are updated
     * 
     * @return JsonResponse a JSON response indicating success or failure of a user deleted
     */
    public function delete(string $uuid): JsonResponse
    {
        try {

            $user = User::getByUuid($uuid);

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
            
        } catch (\Throwable $e) {
            
            Log::error('Error deleting user: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error deleting user',
            ], 500);
        }
    }
}
