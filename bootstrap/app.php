<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => IsAdmin::class, // Alias for admin middleware
        ]);

        // Append web middleware
        $middleware->web(append: [
            \App\Http\Middleware\Localization::class, // Ensure Localization middleware is used for web routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions (if needed)
    })
    ->create();