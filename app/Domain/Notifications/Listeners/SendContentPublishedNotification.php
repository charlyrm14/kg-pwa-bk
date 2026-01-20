<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\Contents\Events\ContentPublishedEvent;
use App\Domain\Notifications\Services\ContentNotificationService;

class SendContentPublishedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly ContentNotificationService $notificationService
    ){}

    public function handle(ContentPublishedEvent $event): void
    {
        $content = $event->content;
        $content->loadMissing('type');
        $this->notificationService->notify($content);
    }
}