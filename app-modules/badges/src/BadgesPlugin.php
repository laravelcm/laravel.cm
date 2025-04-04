<?php

declare(strict_types=1);

namespace Laravelcm\Badges;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class badgesPlugin implements Plugin
{
    public function getId(): string
    {
        return 'badges';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/Resources',
            for: 'Laravelcm\\Badges\\Filament\\Resources'
        );
    }

    public function boot(Panel $panel): void {}
}
