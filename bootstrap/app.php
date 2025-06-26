<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureTwoFactorEnabled;
use App\Http\Middleware\RedirectIfTwoFactorEnabled;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            '2fa' => EnsureTwoFactorEnabled::class,
            'redirect.2fa.confirmed' => RedirectIfTwoFactorEnabled::class
        ]);

        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
