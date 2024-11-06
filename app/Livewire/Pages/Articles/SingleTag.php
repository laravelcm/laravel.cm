<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleTag extends Component
{
    use WithInfiniteScroll;

    public Tag $tag;

    public function render(): View
    {
        return view('livewire.pages.articles.tag', [
            'articles' => Article::with(['tags', 'user', 'user.transactions'])
                ->whereHas('tags', function ($query): void {
                    $query->where('id', $this->tag->id);
                })
                ->withCount(['views', 'reactions'])
                ->scopes(['published', 'notPinned'])
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->paginate($this->perPage),
        ])->title($this->tag->name);
    }
}
