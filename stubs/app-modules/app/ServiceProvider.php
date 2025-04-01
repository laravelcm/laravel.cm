<?php

declare(strict_types=1);

namespace Laravelcm\StubComposerName\Providers;

use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravelcm\StubComposerName\StubComposerNamePlugin;

final class StubComposerNameServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => $panel->getId() !== 'admin' || $panel->plugin(new StubComposerNamePlugin));
    }

    public function boot(): void
    {
        Relation::morphMap([]);
    }
}
