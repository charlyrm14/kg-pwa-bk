<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{User};
use Illuminate\Support\Arr;
use App\Http\Requests\User\{
    StoreUserRequest
};
use Illuminate\Support\Facades\{
    Log,
    DB
};
use Illuminate\Http\JsonResponse;
use App\Http\Resources\User\NewUserResource;

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

            $userData = Arr::only($request->validated(), [
                'name', 
                'last_name', 
                'mother_last_name', 
                'email', 
                'role_id'
            ]);

            $userProfileData = Arr::only($request->validated(), [
                'birthdate', 
                'phone_number', 
                'address', 
                'gender_id'
            ]);

            DB::beginTransaction();

            $user = User::create($userData);
            $user->profile()->create($userProfileData);

            DB::commit();
            
            return response()->json([
                'message' => 'User created successfully',
                'data' => new NewUserResource($user->load(['role', 'profile.gender'])),
            ], 201);

        } catch(\Throwable $e) {

            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error creating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
