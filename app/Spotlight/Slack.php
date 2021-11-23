<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Slack extends SpotlightCommand
{
    protected string $name = 'Slack';

    protected string $description = 'rejoindre le Slack de Laravel Cameroun';

    protected array $synonyms = [
        'community',
        'join',
        'telegram',
        'whatsapp',
        'social',
    ];

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('slack');
    }
}
