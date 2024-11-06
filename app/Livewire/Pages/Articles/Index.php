<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Index extends Component
{
    use WithInfiniteScroll;

    public function render(): View
    {
        return view('livewire.pages.articles.index', [
            'articles' => Article::with(['tags', 'user', 'user.transactions'])
                ->withCount(['views', 'reactions'])
                ->scopes(['published', 'notPinned'])
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->paginate($this->perPage),
            'tags' => Tag::query()->whereHas('articles', function ($query): void {
                $query->published();
            })->orderBy('name')->get(),
        ])
            ->title(__('pages/article.title'));
    }
}
