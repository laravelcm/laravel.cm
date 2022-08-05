<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use App\Traits\WithTags;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Browse extends Component
{
    use WithInfiniteScroll, WithTags;

    protected $queryString = [
        'tag' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

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
        $articles = Article::with('tags')->published()
            ->notPinned()
            ->orderByDesc('sponsored_at')
            ->orderByDesc('submitted_at');

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
