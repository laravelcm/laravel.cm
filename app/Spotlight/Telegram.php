<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class Telegram extends SpotlightCommand
{
    protected string $name = 'Telegram';

    protected string $description = 'rejoindre le groupe sur Telegram';

    /**
     * @var string[]
     */
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
