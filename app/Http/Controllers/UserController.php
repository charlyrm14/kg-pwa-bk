<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserInfoRequest,
};
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User\{
    IndexCollection,
    NewUserResource,
    UpdateUserInfoResource,
    ShowUserResource
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * The function retrieves a paginated list of users with their roles and returns it as a JSON
     * response, handling errors appropriately.
     * 
     * @return JsonResponse The `index` function returns a JSON response. If the list of users is
     * successfully retrieved, it returns a JSON response with a status code of 200 and the data in the
     * response body is formatted using the `IndexCollection`. If the list of users is empty, it
     * returns a JSON response with a status code of 404 and a message indicating that the resource was
     * not found. If an error
     */
    public function index(): JsonResponse
    {
        try {
            
            $users = User::with('role')->orderBy('id', 'DESC')->paginate(15);

            if($users->isEmpty()) {
                return response()->json(['message' => 'Resource not found'], 404);
            }

            return response()->json([
                'data' => new IndexCollection($users)
            ], 200);

        } catch (\Throwable $e) {
            
            Log::error('Error get user list: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error get user list',
            ], 500);

        }
    }
    
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
     * The function `show` retrieves a user's data and related information, handling any errors that
     * may occur.
     * 
     * @param User user The `show` function is a controller method that returns a JSON response with
     * data about a specific user. Here's a breakdown of the parameters used in the function:
     * 
     * @return JsonResponse A JSON response is being returned. If the operation is successful, it will
     * return a JSON response with the data of the user, including their role, schedules for each day,
     * and attendances for the current month. If an error occurs during the process, it will return a
     * JSON response with an error message indicating that there was an error getting the user.
     */
    public function show(User $user): JsonResponse
    {
        try {
            
            return response()->json([
                'data' => new ShowUserResource($user->load('role', 'schedules.day', 'attendancesCurrentMonth'))
            ], 200);

        } catch(\Throwable $e) {

            Log::error('Error to get user: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error to get user',
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
    public function update(UpdateUserInfoRequest $request, string $uuid): JsonResponse
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
     * Delete the specified user from storage
     * 
     * @param string uuid The UUID of the user whose hobbies are updated
     * 
     * @return JsonResponse a JSON response indicating success or failure of a user deleted
     */
    public function destroy(string $uuid): JsonResponse
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
