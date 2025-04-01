<?php

declare(strict_types=1);

namespace Laravelcm\StubClassNamePrefix\Providers;

use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravelcm\StubClassNamePrefix\StubClassNamePrefixPlugin;

final class StubClassNamePrefixServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => $panel->getId() !== 'admin' || $panel->plugin(new StubClassNamePrefixPlugin));
    }

    public function boot(): void
    {
        Relation::morphMap([]);
    }
}
