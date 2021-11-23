<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Forum extends SpotlightCommand
{
    protected string $name = 'Forum';

    protected string $description = 'aller sur le forum';

    protected array $synonyms = [
        'question',
        'thread',
        'sujet',
        'problème',
        'issue',
    ];

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('forum.index');
    }
}
