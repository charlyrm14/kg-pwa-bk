<?php

namespace App\Observers;

use App\Models\Chat;
use Illuminate\Support\Str;

class ChatObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(Chat $chat): void
    {
        $chat->uuid = (string) Str::uuid();
    }
}
