<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Providers;

use Illuminate\Support\ServiceProvider;
use Laravelcm\Gamify\Console\MakePointCommand;

final class GamifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(base_path('app-modules/gamify/config/gamify.php'), 'gamify');
    }

    public function boot(): void
    {
        $this->publishes([
            base_path('app-modules/gamify/config/gamify.php') => config_path('gamify.php'),
        ], 'gamify-config');

        $this->loadMigrationsFrom(base_path('app-modules/gamify/database/migrations'));

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakePointCommand::class,
            ]);
        }
    }
}
