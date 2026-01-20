<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Contents\Events\ContentPublishedEvent;
use App\Domain\Notifications\Listeners\SendContentPublishedNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ContentPublishedEvent::class => [
            SendContentPublishedNotification::class,
        ],
    ];
}