<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithLocale;
    use WithoutUrlPagination;
    use WithPagination;

    public function render(): View
    {
        return view('livewire.pages.articles.index', [
            'articles' => Article::with(['tags', 'user', 'user.transactions', 'user.media', 'media']) // @phpstan-ignore-line
                ->withCount(['views', 'reactions'])
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->published()
                ->notPinned()
                ->forLocale($this->locale)
                ->simplePaginate(21),

            'tags' => Cache::remember(
                key: 'articles.tags',
                ttl: now()->addWeek(),
                callback: fn () => Tag::query()->whereHas('articles', function ($query): void {
                    $query->published();
                })->orderBy('name')->get()
            ),
        ])
            ->title(__('pages/article.title'));
    }
}
