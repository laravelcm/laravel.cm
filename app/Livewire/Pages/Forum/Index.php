<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?Channel $currentChannel = null;

    public int $perPage = 10;

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

        $threads = $query
            ->scopes('withViewsCount')
            ->paginate($this->perPage);

        return view('livewire.pages.forum.index', [
            'threads' => $threads,
        ])
            ->title(__('pages/forum.channel_title', ['channel' => isset($this->currentChannel) ? ' ~ '.$this->currentChannel->name : '']));
    }
}
