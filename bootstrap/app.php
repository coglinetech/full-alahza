<?php

require_once __DIR__ . '/../app/Support/helpers.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    apiPrefix: 'api',
)
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'admin.session' => \App\Http\Middleware\AdminSessionExpired::class,
            'admin.nocache' => \App\Http\Middleware\AdminNoCache::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('admin.login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();