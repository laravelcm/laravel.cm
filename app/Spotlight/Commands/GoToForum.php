<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Spotlight\SpotlightCommand;

final class GoToForum extends SpotlightCommand
{
    protected ?string $icon = 'phosphor-chats';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['forum', 'thread', 'question', 'sujet'];

    public function getName(): string
    {
        return __('global.navigation.forum');
    }

    public function getDescription(): string
    {
        return __('global.forum_description');
    }

    public function getUrl(): string
    {
        return route('forum.index');
    }
}
