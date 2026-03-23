<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Spotlight\SpotlightCommand;

final class GoToArticles extends SpotlightCommand
{
    protected ?string $icon = 'phosphor-books';

    protected ?string $group = 'navigation';

    protected array $synonyms = ['article', 'blog', 'post', 'tuto'];

    public function getName(): string
    {
        return __('global.navigation.articles');
    }

    public function getDescription(): string
    {
        return __('global.articles_description');
    }

    public function getUrl(): string
    {
        return route('articles.index');
    }
}
