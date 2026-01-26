<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Channels\Contracts;

use App\DTOs\Notifications\NotificationDTO;
use App\Domain\Notifications\Enums\NotificationChannelType;

interface NotificationChannel 
{
    public function type(): NotificationChannelType;
    public function send(NotificationDTO $payload): void;
}