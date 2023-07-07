<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Discussions extends SpotlightCommand
{
    protected string $name = 'Discussions';

    protected string $description = 'aller à la page des discussions';

    protected array $synonyms = [
        'débat',
        'conversation',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('discussions.index');
    }
}
