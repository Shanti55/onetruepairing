<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule; // ✅ Yeh import add karo

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withBroadcasting(
        channels: __DIR__.'/../routes/channels.php',
        attributes: ['middleware' => ['auth']],
    )
    ->withSchedule(function (Schedule $schedule) { // ✅ Yeh add karo
        $schedule->command('auctions:expire')->hourly();
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user'             => \App\Http\Middleware\IsUserMiddleware::class,
            'service-provider' => \App\Http\Middleware\IsServiceProviderMiddleware::class,
            'admin'            => \App\Http\Middleware\IsAdminMiddleware::class,
            'custom-guest'     => \App\Http\Middleware\CustomGuestMiddleware::class,
            'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            return redirect()->route('frontend.auth.login');
        });
    })->create();