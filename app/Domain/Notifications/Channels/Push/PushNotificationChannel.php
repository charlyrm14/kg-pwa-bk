<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Channels\Push;

use App\Domain\Notifications\Channels\Contracts\NotificationChannel;
use App\DTOs\Notifications\NotificationDTO;

class PushNotificationChannel implements NotificationChannel
{
    public function send(NotificationDTO $payload): void
    {
        $payload;
    }
}