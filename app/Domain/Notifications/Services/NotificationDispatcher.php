<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Services;

use App\DTOs\Notifications\NotificationDTO;
use App\Domain\Notifications\Channels\Socket\SocketNotificationChannel;
use App\Domain\Notifications\Enums\NotificationChannelType;

class NotificationDispatcher
{
    public function __construct(
        private readonly iterable $channels
    ) {}

    public function dispatch(NotificationDTO $payload): void
    {
        foreach ($this->channels as $channel) {
            if (in_array($channel->type(), $payload->channels, true)) {
                $channel->send($payload);
            }
        }
    }
}