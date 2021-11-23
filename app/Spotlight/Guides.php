<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Guides extends SpotlightCommand
{
    protected string $name = 'Guides';

    protected string $description = 'aller à la page du code de conduite';

    protected array $synonyms = [
        'code',
        'conduite',
        'règles',
        'comportement',
    ];

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('rules');
    }
}
