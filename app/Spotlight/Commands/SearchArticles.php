<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Models\Article;
use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightCommandDependencies;
use App\Spotlight\SpotlightCommandDependency;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Support\Collection;

final class SearchArticles extends SpotlightCommand
{
    protected ?string $icon = 'phosphor-books';

    protected ?string $group = null;

    protected array $synonyms = ['article', 'blog', 'post', 'tuto', 'search'];

    public function getName(): string
    {
        return __('global.navigation.articles');
    }

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('article')
                    ->setPlaceholder(__('command-palette.placeholder'))
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchArticle(string $query): Collection
    {
        return Article::search($query)
            ->take(10)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->map(fn (Article $article): SpotlightSearchResult => new SpotlightSearchResult(
                id: $article->id,
                name: $article->title,
                description: $article->user->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $article): void
    {
        $model = Article::query()->find($article);

        if (! $model instanceof Article) {
            return;
        }

        $spotlight->redirect(route('articles.show', $model->slug), navigate: true);
    }
}
