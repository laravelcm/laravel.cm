<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Discussions;

use App\Models\Builders\DiscussionQueryBuilder;
use App\Models\Discussion;
use App\Models\Tag;
use App\Traits\WithLocale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithLocale;
    use WithoutUrlPagination;
    use WithPagination;

    #[Url(as: 'tag', except: '')]
    public string $currentTag = '';

    public string $sortBy = 'recent';

    public function validSort(string $sort): bool
    {
        return in_array($sort, [
            'recent',
            'popular',
            'active',
        ]);
    }

    public function toggleTag(string $tag): void
    {
        $this->currentTag = $this->currentTag !== $tag && $this->tagExists($tag) ? $tag : '';
    }

    public function sort(string $sort): void
    {
        $this->sortBy = $this->validSort($sort) ? $sort : 'recent';
    }

    public function tagExists(string $tag): bool
    {
        return Tag::query()->where('slug', $tag)->exists();
    }

    public function render(): View
    {
        /** @var DiscussionQueryBuilder $query */
        $query = Discussion::with([
            'tags',
            'user:id,name,username,avatar_type',
        ])
            ->withCount(['reactions', 'replies'])
            ->forLocale($this->locale) // @phpstan-ignore-line
            ->notPinned();

        $tags = Cache::remember(
            key: 'discussions.tags',
            ttl: now()->addWeek(),
            callback: fn (): Collection => Tag::query()
                ->whereJsonContains('concerns', ['discussion'])
                ->orderBy('name')
                ->get()
        );

        if (filled($this->currentTag)) {
            $query->forTag($this->currentTag); // @phpstan-ignore-line
        }

        $query->{$this->sortBy}();

        $discussions = $query->simplePaginate(12);

        return view('livewire.pages.discussions.index', [
            'discussions' => $discussions,
            'tags' => $tags,
            'selectedSortBy' => $this->sortBy,
        ])->title(__('pages/discussion.title'));
    }
}
