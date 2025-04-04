<?php

declare(strict_types=1);

namespace Laravelcm\StubClassNamePrefix;

use Filament\Contracts\Plugin;
use Filament\Panel;

final class StubClassNamePrefixPlugin implements Plugin
{
    public function getId(): string
    {
        return 'StubModuleName';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/Resources',
            for: 'Laravelcm\\StubClassNamePrefix\\Filament\\Resources'
        );
    }

    public function boot(Panel $panel): void {}
}
