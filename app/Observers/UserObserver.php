<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $plainPassword = UserService::generateRandomPassword();

        $user->password = Hash::make($plainPassword);
        $user->uuid = (string) Str::uuid();
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->student_code = UserService::generateStudentCode($user->role_id, $user->id);
        $user->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
