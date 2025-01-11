<?php

declare(strict_types=1);

use App\Http\Middleware as AppMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'checkIfBanned' => AppMiddleware\CheckIfBanned::class,
        ]);
        $middleware->web(append: [
            AppMiddleware\LocaleMiddleware::class,
            AppMiddleware\CacheHeaders::class,
            // AppMiddleware\Security\ContentSecurityPolicy::class,
            AppMiddleware\Security\PermissionsPolicy::class,
            AppMiddleware\Security\ReferrerPolicy::class,
            AppMiddleware\Security\StrictTransportSecurity::class,
            AppMiddleware\Security\XFrameOption::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
