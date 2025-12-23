<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * The function `viewProgress` determines if a user can view the progress of another user based on
     * their roles.
     * 
     * @param User authUser The `authUser` parameter represents the authenticated user who is trying to
     * view the progress of another user. This user could be an admin or a regular user.
     * @param User targetUser The `viewProgress` function takes two parameters: `` and
     * ``. The `` parameter represents the authenticated user who is trying to view
     * the progress, and the `` parameter represents the user whose progress is being
     * viewed.
     * 
     * @return bool The `viewProgress` function returns a boolean value. It returns `true` if the
     * authenticated user is an admin or if the authenticated user is trying to view their own
     * progress. Otherwise, it returns `false`.
     */
    public function viewProgress(User $authUser, User $targetUser): bool
    {
        // Admin puede ver cualquiera
        if ($authUser->role_id === 1) {
            return true;
        }

        // Usuario normal solo puede verse a sí mismo
        return $authUser->id === $targetUser->id;
    }
}
