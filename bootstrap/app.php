<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        if (env('PLATFORM') === 'heroku') {
            $middleware->trustProxies(
                at: '*',
                headers: Request::HEADER_X_FORWARDED_AWS_ELB
            );
        }
        $middleware->web(append: [
            \App\Http\Middleware\MarkNotificationsAsRead::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
