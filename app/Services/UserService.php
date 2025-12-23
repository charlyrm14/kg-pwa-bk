<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService {

    /**
     * Generate a student code in the format STU-YYYYMMDD-XXXX
     * where YYYYMMDD is the current date and XXXX is a random 4 digit number
     * 
     * @param int roleId The role ID of the user. Default is 3 (student).
     * @param int|null userId The ID of the user, used to ensure uniqueness if needed.
     * 
     * @return string|null The generated student code or null if the role ID is not for a student.
     */
    public static function generateStudentCode(int $roleId = 3, ?int $userId): ?string 
    {
        if($roleId !== 3) {
            return null;
        }

        $code = 'STU-' . now()->format('Ymd') . '-' . rand(1000, 9999);

        if(!User::where('student_code', $code)->exists()) {
            return $code;
        } 

        return "{$code}-{$userId}";
    }

    /**
     * Generate a random password of a given length.
     * 
     * @param int length The length of the password to be generated. Default is 12.
     * @return string The generated random password.
     */
    public static function generateRandomPassword(int $length = 12): string
    {
        return Str::random($length);
    }

    /**
     * The function `resolveUser` retrieves a user based on a UUID or from the request object,
     * performing authorization checks if necessary.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class in Laravel. It represents an HTTP request and contains information about the request such
     * as input data, headers, and more.
     * @param uuid The `uuid` parameter in the `resolveUser` function is a unique identifier for a
     * user. If a `uuid` is provided as an argument when calling the function, it will attempt to find
     * and return the user with that specific `uuid`. If no `uuid` is provided (or if
     * 
     * @return User The `resolveUser` function returns a `User` object. If a UUID is provided, it
     * retrieves the user with that UUID from the database and checks if the current user has
     * permission to view the progress of the retrieved user. If the permission check fails, an
     * `AuthorizationException` is thrown. If no UUID is provided, it returns the current authenticated
     * user from the request.
     */
    public static function resolveUser(Request $request, ?string $uuid = null): User
    {
        if (!$uuid) {
            return $request->user();
        }

        // Usuario administrador solicita recurso
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($request->user()->cannot('viewProgress', $user)) {
            throw new HttpResponseException(
                response()->json(['message' => "unauthorized"], 403)
            );
        }

        return $user;
    }
}