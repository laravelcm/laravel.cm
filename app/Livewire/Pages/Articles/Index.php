<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithLocale;
    use WithoutUrlPagination;
    use WithPagination;

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
                ->simplePaginate(5),
            'tags' => Tag::query()->whereHas('articles', function ($query): void {
                $query->published();
            })->orderBy('name')->get(),
        ])
            ->title(__('pages/article.title'));
    }
}
