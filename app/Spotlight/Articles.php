<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Articles extends SpotlightCommand
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

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('articles');
    }
}
