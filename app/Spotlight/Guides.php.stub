<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Guides extends SpotlightCommand
{
    protected string $name = 'Guides';

    protected string $description = 'aller à la page du code de conduite';

    protected array $synonyms = [
        'code',
        'conduite',
        'règles',
        'comportement',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('rules');
    }
}
