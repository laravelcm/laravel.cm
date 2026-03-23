<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Spotlight\SpotlightCommand;

final class GoToDiscussions extends SpotlightCommand
{
    protected ?string $icon = 'phosphor-chat-circle-dots';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['discussion', 'débat', 'échange'];

    public function getName(): string
    {
        return __('global.navigation.discussions');
    }

    public function getDescription(): string
    {
        return '';
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('discussions.index'), navigate: true);
    }
}
