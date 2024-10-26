<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.forum')]
final class Index extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?Channel $currentChannel = null;

    public string $search = '';

    public int $perPage = 20;

    public function launchSearch(): void
    {
        //
    }

    #[On('channelUpdated')]
    public function reloadThreads(?int $channelId): void
    {
        if ($channelId) {
            $this->currentChannel = Channel::query()->find($channelId);
        } else {
            $this->currentChannel = null;
        }

        $this->dispatch('render');
    }

    public function render(): View
    {
        $query = Thread::query()
            ->orderByDesc('created_at');

        if ($this->currentChannel?->id) {
            $query->scopes(['channel' => $this->currentChannel]);
        }

        if ($this->search) {
            $query->where(function (Builder $query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            });
        }

        $threads = $query
            ->scopes('withViewsCount')
            ->paginate($this->perPage);

        return view('livewire.pages.forum.index', [
            'threads' => $threads,
        ])
            ->title(__('pages/forum.channel_title', ['channel' => isset($this->currentChannel) ? ' ~ '.$this->currentChannel->name : '']));
    }
}
