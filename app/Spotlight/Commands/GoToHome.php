<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Spotlight\SpotlightCommand;

final class GoToHome extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-home';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['home', 'accueil'];

    public function getName(): string
    {
        return __('global.navigation.home');
    }

    public function getUrl(): string
    {
        return route('home');
    }
}
