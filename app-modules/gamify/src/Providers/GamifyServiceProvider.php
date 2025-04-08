<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravelcm\Badges\Console\MakePointCommand;
use Spatie\LaravelPackageTools\Package;

final class GamifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::morphMap([]);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('gamify')
            ->hasConfigFile()
            ->hasMigrations([
                'add_reputation_on_user_table',
                'create_gamify_tables',
            ])
            ->hasCommands([
                MakePointCommand::class,
            ]);
    }
}
