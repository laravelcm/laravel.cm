<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Spotlight\SpotlightCommand;

final class GoToRules extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-shield-check';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['rules', 'règles', 'conduite'];

    public function getName(): string
    {
        return __('global.navigation.rules');
    }

    public function getUrl(): string
    {
        return route('rules');
    }
}
