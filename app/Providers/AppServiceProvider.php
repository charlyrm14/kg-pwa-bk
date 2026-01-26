<?php

namespace App\Providers;

use App\Models\Content;
use Carbon\CarbonInterval;
use Laravel\Passport\Passport;
use App\Observers\SlugObserver;
use Illuminate\Support\ServiceProvider;
use App\Domain\Notifications\Services\NotificationDispatcher;
use App\Domain\Notifications\Channels\Push\PushNotificationChannel;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NotificationDispatcher::class, function() {
            return new NotificationDispatcher([
                app(PushNotificationChannel::class),
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
