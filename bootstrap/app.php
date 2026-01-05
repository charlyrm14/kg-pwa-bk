<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\{
    PassportCookieAuth,
    ApiAuthenticate
};
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'passport.cookie' => PassportCookieAuth::class,
            'auth:api' => ApiAuthenticate::class
        ]);
        $middleware->group('api', [
            PassportCookieAuth::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function(Throwable $e, $request) {
                        
            if ($e instanceof AuthenticationException ||
                $e instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException
            ) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            if ($e instanceof AuthorizationException) {
                return response()->json(['message' => 'Forbidden.'], 403);
            }
            
            return response()->json(['error' => 'Server error'], 500);
        });
    })->create();
