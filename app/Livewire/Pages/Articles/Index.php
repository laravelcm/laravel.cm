<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Index extends Component
{
    use WithInfiniteScroll;
    use WithLocale;

    public function mount(): void
    {
        $this->locale = config('app.locale');
    }

    public function render(): View
    {
        return view('livewire.pages.articles.index', [
            'articles' => Article::with(['tags', 'user', 'user.transactions']) // @phpstan-ignore-line
                ->withCount(['views', 'reactions'])
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->published()
                ->notPinned()
                ->forLocale($this->locale)
                ->paginate($this->perPage),
            'tags' => Tag::query()->whereHas('articles', function ($query): void {
                $query->published();
            })->orderBy('name')->get(),
        ])
            ->title(__('pages/article.title'));
    }
}
