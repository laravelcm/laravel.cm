<?php

declare(strict_types=1);

namespace App\Spotlight;

use App\Models\Article as ArticleModel;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

final class Article extends SpotlightCommand
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

    public function searchArticle(string $query): Collection
    {
        return ArticleModel::published()
            ->with('user')
            ->where('title', 'like', "%{$query}%")
            ->get()
            ->map(fn (ArticleModel $article) => new SpotlightSearchResult(
                $article->slug(),
                $article->title,
                sprintf('par @%s', $article->user?->username)
            ));
    }

    public function execute(Spotlight $spotlight, ArticleModel $article): void
    {
        $spotlight->redirectRoute('articles.show', $article);
    }
}
