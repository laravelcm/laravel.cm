<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

uses(Tests\TestCase::class);

it('registers the unsubscribe route with signed middleware', function (): void {
    $route = Route::getRoutes()->getByName('subscriptions.unsubscribe');

    expect($route)->not->toBeNull()
        ->and($route->gatherMiddleware())->toContain('signed');
});
