<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routeBindings();

        $this->routes(function (): void {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            name: 'api',
            callback: fn (Request $request): Limit => Limit::perMinute(60)
                ->by(
                    (string) (optional($request->user())->id ?: $request->ip())
                )
        );
    }

    protected function routeBindings(): void
    {
        Route::bind(
            key: 'username',
            binder: fn (string $username): User => User::findByUsername($username)
        );
    }
}
