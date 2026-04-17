<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Spotlight\SpotlightCommand;

final class GoToChangelog extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-megaphone';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['changelog', 'release', 'releases', 'mises à jour', 'nouveautés'];

    public function getName(): string
    {
        return __('global.navigation.changelog');
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('changelog'), navigate: true);
    }
}
