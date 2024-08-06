<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
        then: function () {
            Route::middleware("web")->group([base_path("routes/app.php")]);
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(
            append: [
                \App\Http\Middleware\HandleInertiaRequests::class,
                \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            ]
        );

        $middleware->trustHosts(at: ["127.0.0.1", "::1", "localhost"]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
