<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class Articles extends SpotlightCommand
{
    protected string $name = 'Articles';

    protected string $description = 'aller à la page des articles';

    protected array $synonyms = [
        'articles',
        'article',
        'post',
        'blog',
        'news',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('articles');
    }
}
