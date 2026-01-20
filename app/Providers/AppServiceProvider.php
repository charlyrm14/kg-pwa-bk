<?php

namespace App\Providers;

use App\Models\Content;
use App\Observers\SlugObserver;
use Carbon\CarbonInterval;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Domain\Notifications\Channels\Push\PushNotificationChannel;
use App\Domain\Notifications\Channels\Socket\SocketNotificationChannel;
use App\Domain\Notifications\Services\NotificationDispatcher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationDispatcher::class, function($app) {
            return new NotificationDispatcher([
                $app->make(PushNotificationChannel::class),
                $app->make(SocketNotificationChannel::class)
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Content::observe(SlugObserver::class);

        Passport::ignoreRoutes();
        Passport::tokensExpireIn(CarbonInterval::days(15));
        Passport::refreshTokensExpireIn(CarbonInterval::days(30));
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
    }
}
