<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Essential 'web' middleware group
        $middleware->web(append: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // Corrected namespace for CSRF
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // 'api' middleware group with Sanctum and other defaults
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        // Also ensure these are present, they are usually default for 'api' group
        $middleware->api(append: [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);


        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
