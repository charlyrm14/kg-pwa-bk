<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Channels\Socket;

use App\Domain\Notifications\Channels\Contracts\NotificationChannel;
use App\DTOs\Notifications\NotificationDTO;
use App\Events\NotificationBroadcasted;

class SocketNotificationChannel implements NotificationChannel
{
    public function send(NotificationDTO $payload): void
    {
        broadcast(new NotificationBroadcasted($payload));
    }
}