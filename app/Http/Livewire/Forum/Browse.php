<?php

namespace App\Http\Livewire\Forum;

use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithInfiniteScroll;
use Livewire\Component;

class Browse extends Component
{
    use WithInfiniteScroll;

    public ?Channel $channel = null;
    public string $sortBy = 'recent';

    protected $queryString = [
        'sortBy' => ['except' => 'recent'],
    ];

    public function validSort($sort): bool
    {
        return in_array($sort, [
            'recent',
            'resolved',
            'unresolved',
        ]);
    }

    public function sortBy($sort): void
    {
        $this->sortBy = $this->validSort($sort) ? $sort : 'recent';
    }

    public function render()
    {
        $threads = Thread::feedQuery();

        if ($this->channel) {
            $threads->forChannel($this->channel->slug());
        }

        $threads->{$this->sortBy}();

        return view('livewire.forum.browse', [
            'threads' => $threads->withviewscount()->paginate($this->perPage),
            'selectedSortBy' => $this->sortBy,
        ]);
    }
}