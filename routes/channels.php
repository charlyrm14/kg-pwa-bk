<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{userId}', function($user, int $userID) {
    return (int) $user->id === (int) $userId;
});