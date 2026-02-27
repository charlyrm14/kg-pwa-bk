<?php

declare(strict_types=1);

namespace App\Domain\Users\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResolverUserService
{
    /**
     * Resolve target user based on authenticated user and optional UUID.
     *
     * - If UUID is null, returns authenticated user
     * - If UUID is provided, validates authorization via policy ability
     *
     * @param Request $request
     * @param string|null $uuid
     * @param string $ability
     * @return User
     */
    public static function resolve(Request $request, ?string $uuid, string $ability): User
    {
        if (!$uuid) {
            return $request->user();
        }

        // Usuario administrador solicita recurso
        $user = User::where('uuid', $uuid)->firstOrFail();

        if ($request->user()->cannot($ability, $user)) {
            throw new HttpResponseException(
                response()->json(['message' => "unauthorized"], 403)
            );
        }

        return $user;
    }
}
