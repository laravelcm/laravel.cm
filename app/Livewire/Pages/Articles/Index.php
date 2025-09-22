<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithLocale;
    use WithPagination;

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
                ->simplePaginate(21),
            'tags' => Cache::remember(
                key: 'articles.tags',
                ttl: now()->addWeek(),
                callback: fn (): Collection => Tag::query()->whereHas('articles', function ($query): void {
                    $query->published(); // @phpstan-ignore-line
                })->orderBy('name')
                    ->get()
            ),
        ])
            ->title(__('pages/article.title'));
    }
}
