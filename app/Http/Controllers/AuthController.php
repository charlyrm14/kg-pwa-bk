<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                secure: config('auth.cookie_secure_env'),
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

    /**
     * The function logs out a user by revoking their token and deleting the access token cookie.
     * 
     * @param Request request The `logout` function you provided is a PHP function that handles the
     * logout process for a user. It takes a `Request` object as a parameter, which is typically an
     * HTTP request sent to the server.
     * 
     * @return JsonResponse The `logout` function returns a JSON response with a success message
     * "Logout successful" and a status code of 200 if the logout process is successful. Additionally,
     * it sets a cookie to forget the token access name. If an error occurs during the logout process,
     * it returns a JSON response with an error message "Error during logout process" and a status code
     * of 500.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        try {

            $token = $user->token();

            if ($token) $token->revoke();

            $cookie = cookie(
                name: config('auth.token_access_name'),
                value: '',
                minutes: -1, // elimina
                path: '/',
                domain: null,
                secure: config('auth.cookie_secure_env'),
                httpOnly: true,
                sameSite: 'Strict'
            );

            return response()
                ->json(['message' => 'Logout successful'], 200)
                ->cookie($cookie);

        } catch(\Throwable $e) {
            Log::error("Logout error: " . $e->getMessage());
            return response()->json(["error" => 'Error during logout process'], 500);
        }
    }
}
