<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Discussions extends SpotlightCommand
{
    protected string $name = 'Discussions';

    protected string $description = 'aller à la page des discussions';

    protected array $synonyms = [
        'débat',
        'conversation'
    ];

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('discussions.index');
    }
}
