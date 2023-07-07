<?php

declare(strict_types=1);

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Tag;
use App\Traits\WithInfiniteScroll;
use App\Traits\WithTags;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Browse extends Component
{
    use WithInfiniteScroll;
    use WithTags;

    /**
     * @var array[]
     */
    protected $queryString = [
        'tag' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

    public function validSort(string $sort): bool
    {
        return in_array($sort, [
            'recent',
            'popular',
            'active',
        ]);
    }

    public function render(): View
    {
        $discussions = Discussion::with('tags')
            ->withCount('replies')
            ->notPinned();

        $tags = Tag::whereJsonContains('concerns', ['discussion'])->orderBy('name')->get();

        $selectedTag = Tag::where('name', $this->tag)->first();

        if ($this->tag) {
            $discussions->forTag($this->tag);
        }

        $discussions->{$this->sortBy}();

        return view('livewire.discussions.browse', [
            'discussions' => $discussions->paginate($this->perPage),
            'tags' => $tags,
            'selectedTag' => $selectedTag,
            'selectedSortBy' => $this->sortBy,
        ]);
    }
}
