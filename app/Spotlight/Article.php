<?php

namespace App\Spotlight;

use App\Models\Article as ArticleModel;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Article extends SpotlightCommand
{
    protected string $name = 'Article';

    protected string $description = 'rechercher un article spécifique';

    protected array $synonyms = [];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('article')
                    ->setPlaceholder('Rechercher un article spécifique')
            );
    }

    public function searchArticle($query)
    {
        return ArticleModel::published()->where('title', 'like', "%$query%")
            ->get()
            ->map(function (ArticleModel $article) {
                return new SpotlightSearchResult(
                    $article->slug(),
                    $article->title,
                    sprintf('par @%s', $article->author->username)
                );
            });
    }

    public function execute(Spotlight $spotlight, ArticleModel $article)
    {
        $spotlight->redirectRoute('articles.show', $article);
    }
}
