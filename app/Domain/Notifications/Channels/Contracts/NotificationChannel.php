<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Channels\Contracts;

use App\DTOs\Notifications\NotificationDTO;

interface NotificationChannel 
{
    public function send(NotificationDTO $payload): void;
}