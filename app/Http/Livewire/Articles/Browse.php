<?php

declare(strict_types=1);

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use App\Traits\WithTags;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Browse extends Component
{
    use WithInfiniteScroll;
    use WithTags;

    public string $viewMode = 'list';

    protected $queryString = [
        'tag' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

    public function mount()
    {
        $this->viewMode = session('viewMode', $this->viewMode);
    }

    public function changeViewMode($mode)
    {
        session()->put('viewMode', $mode);

        $this->viewMode = $mode;
    }

    public function validSort($sort): bool
    {
        return in_array($sort, [
            'recent',
            'popular',
            'trending',
        ]);
    }

    public function render(): View
    {
        $articles = Article::with('tags')
            ->withCount(['views', 'reactions'])
            ->published()
            ->notPinned()
            ->orderByDesc('sponsored_at')
            ->orderByDesc('published_at');

        $tags = Tag::whereHas('articles', function ($query) {
            $query->published();
        })->orderBy('name')->get();

        $selectedTag = Tag::where('name', $this->tag)->first();

        if ($this->tag) {
            $articles->forTag($this->tag);
        }

        $articles->{$this->sortBy}();

        return view('livewire.articles.browse', [
            'articles' => $articles->paginate($this->perPage),
            'tags' => $tags,
            'selectedTag' => $selectedTag,
            'selectedSortBy' => $this->sortBy,
        ]);
    }
}
