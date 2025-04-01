<?php

declare(strict_types=1);

namespace Laravelcm\StubComposerName;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class StubComposerNamePlugin implements Plugin
{
    public function getId(): string
    {
        return 'StubComposerName';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/Resources',
            for: 'Laravelcm\\StubComposerName\\Filament\\Resources'
        );
    }

    public function boot(Panel $panel): void {}
}
