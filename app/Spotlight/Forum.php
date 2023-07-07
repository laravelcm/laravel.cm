<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Forum extends SpotlightCommand
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

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('forum.index');
    }
}
