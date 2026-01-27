<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Channels\Push;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notification;
use App\DTOs\Notifications\NotificationDTO;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Models\Notification as NotificationModel;

class PushNotificationChannel extends Notification
{
    private const ICON_PATH = '/assets/media/notification.png';

    public function __construct(
        private readonly NotificationModel $notification
    ) {}

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title($this->notification->title)
            ->body($this->notification->body)
            ->icon(asset(self::ICON_PATH))
            ->data([
                'notification_id' => $this->notification->id,
                'url' => config('app.frontend_url') . '/' . $this->notification->action_url,
            ]);
    }
}