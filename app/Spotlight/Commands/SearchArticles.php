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
    protected string $name = 'Rechercher un article';

    protected string $description = '';

    protected ?string $icon = 'phosphor-books-duotone';

    protected ?string $group = 'search';

    protected array $synonyms = ['search article', 'chercher article'];

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('article')
                    ->setPlaceholder(__('global.search').'...')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchArticle(string $query): Collection
    {
        return Article::search($query)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->take(10)
            ->map(fn (Article $article): SpotlightSearchResult => new SpotlightSearchResult(
                id: $article->id,
                name: $article->title,
                description: $article->user?->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $article): void
    {
        $model = Article::query()->findOrFail($article);

        $spotlight->redirect(route('articles.show', $model->slug), navigate: true);
    }

    public function getUrl(): string
    {
        return route('articles.index');
    }
}
