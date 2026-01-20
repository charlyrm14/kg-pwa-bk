<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Services;

use App\Domain\Notifications\Channels\Contracts\NotificationChannel;
use App\DTOs\Notifications\NotificationDTO;
use App\Domain\Notifications\Channels\Socket\SocketNotificationChannel;

class NotificationDispatcher
{
    public function __construct(
        private iterable $channels
    ){}

    public function dispatch(NotificationDTO $payload): void
    {
        app(SocketNotificationChannel::class)->send($payload);
    }
}