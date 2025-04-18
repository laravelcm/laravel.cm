<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Providers;

use Illuminate\Support\ServiceProvider;
use Laravelcm\Gamify\Console\MakePointCommand;

final class GamifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/gamify.php', 'gamify');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/gamify.php' => config_path('gamify.php'),
        ], 'gamify');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakePointCommand::class,
            ]);
        }
    }
}
