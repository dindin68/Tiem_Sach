<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'customer' => \App\Http\Middleware\EnsureUserIsCustomer::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

    })

    ->withSchedule(function (Schedule $schedule) {
    $schedule->command('promotions:remove-expired')->hourly();
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
