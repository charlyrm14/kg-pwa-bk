<?php

namespace App\Domain\Notifications\Enums;

enum NotificationChannelType: string
{
    case PUSH = 'push';
    case SOCKET = 'socket';
    case EMAIL = 'email';
    case SMS = 'sms';
}