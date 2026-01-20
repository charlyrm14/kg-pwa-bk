<?php

declare(strict_types=1);

namespace App\DTOs\Notifications;

use App\Models\Notification;

final class NotificationDTO
{
    public function __construct(
        public readonly Notification $notification,
        public readonly int $userId
    ){}
} 
