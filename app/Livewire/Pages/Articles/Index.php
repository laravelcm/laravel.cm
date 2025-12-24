<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Builders\ArticleQueryBuilder;
use App\Models\Tag;
use App\Models\User;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithLocale;
    use WithPagination;

    /**
     * @return Collection<int, User>
     */
    #[Computed(cache: true)]
    public function topAuthors(): Collection
    {
        /** @var Collection<int, User> */
        return Cache::remember(
            key: 'top_authors',
            ttl: now()->addWeeks(2),
            callback: fn (): Collection => User::query()
                ->select(['id', 'name', 'username', 'avatar_type'])
                ->whereHas('articles', function ($query): void {
                    /** @var ArticleQueryBuilder $query */
                    $query->published();
                })
                ->withCount(['articles' => function ($query): void {
                    /** @var ArticleQueryBuilder $query */
                    $query->published();
                }])
                ->orderByDesc('articles_count')
                ->limit(5)
                ->get()
        );
    }

    public function render(): View
    {
        return view('livewire.pages.articles.index', [
            // @phpstan-ignore-next-line
            'articles' => Article::with([
                'tags',
                'user:id,username,name,avatar_type',
                'media',
            ])
                ->withCount(['views', 'reactions'])
                ->published()
                ->orderByDesc('published_at')
                ->forLocale($this->locale)
                ->simplePaginate(20),
            'tags' => Cache::tags('tags')->remember(
                key: 'tags',
                ttl: now()->addWeek(),
                callback: fn (): Collection => Tag::query()->whereHas('articles', function ($query): void {
                    /** @var ArticleQueryBuilder $query */
                    $query->published();
                })->orderBy('name')
                    ->get()
            ),
        ])
            ->title(__('pages/article.title'));
    }
}
