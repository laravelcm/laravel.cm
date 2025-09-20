<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleTag extends Component
{
    use WithInfiniteScroll;
    use WithLocale;

    public Tag $tag;

    public function render(): View
    {
        return view('livewire.pages.articles.tag', [
            'articles' => Article::with(['tags', 'user:id,name,username,avatar_type']) // @phpstan-ignore-line
                ->whereHas('tags', function ($query): void {
                    $query->where('id', $this->tag->id);
                })
                ->withCount(['views', 'reactions'])
                ->published()
                ->orderByDesc('published_at')
                ->forLocale($this->locale)
                ->paginate($this->perPage),
        ])->title($this->tag->name);
    }
}
