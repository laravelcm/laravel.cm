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

    public function mount(): void
    {
        $this->locale = config('app.locale');
    }

    public function render(): View
    {
        return view('livewire.pages.articles.tag', [
            'articles' => Article::with(['tags', 'user', 'user.transactions']) // @phpstan-ignore-line
                ->whereHas('tags', function ($query): void {
                    $query->where('id', $this->tag->id);
                })
                ->withCount(['views', 'reactions'])
                ->orderByDesc('sponsored_at')
                ->orderByDesc('published_at')
                ->published()
                ->notPinned()
                ->forLocale($this->locale)
                ->paginate($this->perPage),
        ])->title($this->tag->name);
    }
}
