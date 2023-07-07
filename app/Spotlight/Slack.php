<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Slack extends SpotlightCommand
{
    protected string $name = 'Slack';

    protected string $description = 'rejoindre le Slack de Laravel Cameroun';

    protected array $synonyms = [
        'community',
        'join',
        'telegram',
        'whatsapp',
        'social',
        'discord',
        'rejoindre',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('slack');
    }
}
