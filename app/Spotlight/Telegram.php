<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class Telegram extends SpotlightCommand
{
    protected string $name = 'Telegram';

    /**
     * This is the description of your command which will be shown besides the command name.
     */
    protected string $description = 'rejoindre le groupe sur Telegram';

    /**
     * You can define any number of additional search terms (also known as synonyms)
     * to be used when searching for this command.
     */
    protected array $synonyms = [
        'channels',
        'social',
        'slack',
        'whatsapp',
        'community',
    ];

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('telegram');
    }
}
