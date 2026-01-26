<?php

declare(strict_types=1);

namespace App\Domain\Notifications\Services;

use App\Models\{
    User,
    Content,
    NotificationType,
    Notification
};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DTOs\Notifications\NotificationDTO;
use App\Domain\Notifications\Services\NotificationDispatcher;
use App\Domain\Notifications\Channels\Push\PushNotificationChannel;
use App\Domain\Notifications\Enums\NotificationChannelType;

class ContentNotificationService
{
    private const NEWCONTENTSLUG = 'nuevo-contenido';

    public function __construct(
        private readonly NotificationDispatcher $dispatcher
    ){}

    public function notify(Content $content): void
    {
        DB::transaction(function () use($content) {

            $notificationType = NotificationType::where('slug', self::NEWCONTENTSLUG)->first();

            if(!$notificationType) return;

            $notification = Notification::create([
                'title' => $this->buildTitle($content),
                'body' => Str::limit($content->name, 60, ('...')),
                'notification_type_id' => $notificationType->id,
                'action_url' => $this->buildActionUrl($content),
                'is_broadcast' => true,
                'created_by_user_id' => $content->author_id
            ]);
            
            User::query()
                ->select('id')
                ->chunkById(100, function ($users) use ($notification) {

                    $rows = $users->map(fn ($user) => [
                        'user_id' => $user->id,
                        'notification_id' => $notification->id,
                        'is_read' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('user_notifications')->insert($rows->toArray());
                    
                    foreach ($users as $user) {
                        $user->notify(new PushNotificationChannel($notification));
                    }
                    
                });
        });
    }

    private function buildTitle(Content $content): string
    {
        return match($content->type->slug ?? null) {
            'noticias' => 'Nueva noticia publicada',
            'eventos' => 'Nuevo evento publicado',
            'consejos' => 'Nuevo consejo publicado',
            'nutricion' => 'Nuevo tipo de nutrición',
            default => 'Nuevo contenido disponible'
        };
    }

    private function buildActionUrl(Content $content): string
    {
        return match($content->type->slug ?? null) {
            'noticias' => "contents/noticias/{$content->slug}",
            'eventos' => "contents/eventos/{$content->slug}",
            'consejos' => "contents/consejos/{$content->slug}",
            'nutricion' => "contents/nutricion/{$content->slug}",
            default => "contents/noticias/{$content->slug}"
        };
    }
}