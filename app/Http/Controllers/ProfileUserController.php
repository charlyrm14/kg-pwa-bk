<?php

namespace App\Http\Controllers;

use Illuminate\Http\{
    Request,
    JsonResponse
};
use Illuminate\Support\Facades\Log;
use App\Domain\Media\Services\MediaAttachService;
use App\Http\Resources\Profile\UserDetailInfoResource;
use App\Http\Requests\User\UpdateUserProfileRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\Profile\UpdateUserProfileResource;

class ProfileUserController extends Controller
{
    private const AVATAR_CONTEXT = 'avatar';

    public function __construct(
        private MediaAttachService $mediaAttachService
    ){}
    /**
     * The function retrieves and returns detailed information about a user, including their role,
     * profile gender, and hobbies, in a JSON response.
     * 
     * @return JsonResponse A JsonResponse is being returned. If the user is found, it will return a
     * JSON response with the user's detailed information including their role, profile gender, and
     * hobbies. If the user is not found or an error occurs, appropriate error responses will be
     * returned.
     */
    public function show(Request $request): JsonResponse
    {
        try {

            $user = $request->user();

            if(!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->load(['role', 'profile.gender', 'hobbies', 'profile.avatar']);

            return response()->json([
                'data' => new UserDetailInfoResource($user)  
            ], 200);

        } catch(\Throwable $e) {

            Log::error('Error getting user basic info: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error getting user basic info',
            ], 500);
        }    
    }

    /**
     * The function `update` in PHP updates a user's profile information and returns a JSON response
     * with success or error messages.
     * 
     * @param UpdateUserProfileRequest request The `update` function you provided is a method that
     * handles updating a user's profile based on the data provided in the `UpdateUserProfileRequest`
     * request. Here's a breakdown of the function:
     * 
     * @return JsonResponse The `update` function returns a JSON response. If the user is not found, it
     * returns a 404 response with a message 'User not found'. If the user is found, it updates the
     * user's profile information and returns a 201 response with a success message 'User profile
     * updated successfully' along with the updated user profile data in the response body. If an error
     * occurs during the update process
     */
    public function update(UpdateUserProfileRequest $request): JsonResponse
    {
        try {
            
            $user = $request->user();

            $user->profile()->updateOrCreate([], $request->validated());

            $this->mediaAttachService->attach(
                $user->profile, 
                $request->validated()['profile_image'] ?? [], 
                self::AVATAR_CONTEXT
            );

            $user->load([
                'profile.gender',
                'profile.avatar',
            ]);

            return response()->json([
                'message' => 'User profile updated successfully',
                'data' => new UpdateUserProfileResource($user)
            ], 200);

        } catch (HttpResponseException $e) {

            Log::error("Error to user profile validation: " . $e->getMessage());
            throw $e;

        } catch(\Throwable $e) {

            Log::error('Error updating user profile info: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error updating user profile info',
            ], 500);
        }
    }
}
