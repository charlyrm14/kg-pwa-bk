<?php

namespace App\Observers;

use App\Models\Content;
use App\Domain\Contents\Events\ContentPublishedEvent;

class ContentObserver
{
    private const PUBLISHED = 'publicado';

    /**
     * Handle the Content "created" event.
     */
    public function created(Content $content): void
    {
        if($content->status && $content->status->slug === self::PUBLISHED) {
            ContentPublishedEvent::dispatch($content);
        }
    }

    /**
     * Handle the Content "updated" event.
     */
    public function updated(Content $content): void
    {
        if($content->wasChanged('content_status_id') && $content->status?->slug === self::PUBLISHED) {
            ContentPublishedEvent::dispatch($content);
        }
    }

    /**
     * Handle the Content "deleted" event.
     */
    public function deleted(Content $content): void
    {
        //
    }

    /**
     * Handle the Content "restored" event.
     */
    public function restored(Content $content): void
    {
        //
    }

    /**
     * Handle the Content "force deleted" event.
     */
    public function forceDeleted(Content $content): void
    {
        //
    }
}
