<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\{User};
use App\Http\Requests\User\{
    StoreUserRequest
};
use Illuminate\Support\Facades\{
    Log
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

            $user = User::create($request->validated());
            
            return response()->json([
                'message' => 'User created successfully',
                'data' => new NewUserResource($user->load('role')),
            ], 201);

        } catch(\Throwable $e) {

            Log::error('Error creating user: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error creating user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
