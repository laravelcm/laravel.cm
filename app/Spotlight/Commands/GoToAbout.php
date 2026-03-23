<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Spotlight\SpotlightCommand;

final class GoToAbout extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-information-circle';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['about', 'à propos'];

    public function getName(): string
    {
        return __('global.navigation.about');
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('about'), navigate: true);
    }
}
