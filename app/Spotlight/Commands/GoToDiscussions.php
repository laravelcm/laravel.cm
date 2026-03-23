<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

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

    public function getUrl(): string
    {
        return route('discussions.index');
    }
}
