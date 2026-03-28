<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware alias
        $middleware->alias([
            'checkRole' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        // Atau Anda bisa menambahkan middleware lainnya di sini
        // $middleware->append(\App\Http\Middleware\ExampleMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();