<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

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
