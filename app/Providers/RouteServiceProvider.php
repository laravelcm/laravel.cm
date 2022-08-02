<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routeBindings();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth', 'role:moderator|admin'])
                ->namespace($this->namespace)
                ->prefix('cpanel')
                ->as('cpanel.')
                ->group(base_path('routes/cpanel.php'));
        });

        Route::macro('redirectMap', function ($map, $status = 302) {
            foreach ($map as $old => $new) {
                Route::redirect($old, $new, $status)->name($old);
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by((string) (optional($request->user())->id ?: $request->ip()));
        });
    }

    protected function routeBindings(): void
    {
        Route::bind('username', function (string $username) {
            return \App\Models\User::findByUsername($username);
        });
    }
}
