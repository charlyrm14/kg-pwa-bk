<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

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
}