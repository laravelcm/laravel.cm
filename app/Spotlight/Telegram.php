<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Telegram extends SpotlightCommand
{
    protected string $name = 'Telegram';

    protected string $description = 'rejoindre le groupe sur Telegram';

    protected array $synonyms = [
        'channels',
        'community',
        'telegram',
        'groupe',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('telegram');
    }
}
