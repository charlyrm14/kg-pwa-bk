<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginUserResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{
    Auth,
    Log
};

class AuthController extends Controller
{
    private const TOKEN_TYPE = 'Bearer';
    
    /**
     * The function handles user login, checks for valid credentials, enforces password change if
     * required, generates a token, and returns user data with a token in a JSON response.
     * 
     * @param LoginRequest request The `login` function you provided is responsible for handling user
     * login requests. It attempts to authenticate the user with the provided email and password using
     * Laravel's `Auth::attempt` method. Here's a breakdown of the code:
     * 
     * @return JsonResponse The `login` function returns a JSON response with user data, token
     * information, and expiration time if the login attempt is successful. If the login attempt fails
     * due to invalid credentials, it returns a JSON response with a message indicating the invalid
     * credentials. If the user is required to change their password, it returns a JSON response with a
     * message indicating that a password change is required. If an error occurs during
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {

            if(!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = Auth::user();
            
            if($user->force_password_change === 1) {
                return response()->json(['message' => 'Password change required'], 403);
            }

            $token = $user->createToken(config('auth.token_access_name'));
            $user->load('role');

            $cookie = cookie(
                name: config('auth.token_access_name'),
                value: $token->accessToken,
                minutes: 60 * 2,
                path: '/',
                domain: null,
                secure: true,
                httpOnly: true,
                sameSite: 'Strict'
            );

            return response()
            ->json([
                'data' => [
                    'user' => new LoginUserResource($user),
                    'token' => $token->accessToken,
                    'token_type' => self::TOKEN_TYPE,
                    'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
                ]
            ], 200)
            ->cookie($cookie);

        } catch (\Throwable $e) {
            Log::error("Login error: " . $e->getMessage());
            return response()->json(["error" => 'Error during login process'], 500);
        }
    }
}
