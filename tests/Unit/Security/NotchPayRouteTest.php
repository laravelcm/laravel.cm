<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

uses(Tests\TestCase::class);

it('registers the notchpay-callback route with throttle middleware', function (): void {
    $route = Route::getRoutes()->getByName('notchpay-callback');

    expect($route)->not->toBeNull()
        ->and(implode(',', $route->gatherMiddleware()))->toContain('throttle');
});
