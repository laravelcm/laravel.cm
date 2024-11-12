<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.forum')]
final class Index extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    #[Url(as: 'channel')]
    public ?string $channel = null;

    #[Url(as: 'solved')]
    public ?string $solved = null;

    #[Url(as: 'me')]
    public ?string $user = null;

    #[Url(as: 'no-replies')]
    public ?string $unAnswered = null;

    #[Url]
    public ?string $subscribe = null;

    public ?Channel $currentChannel = null;

    public string $search = '';

    public int $perPage = 30;

    public function mount(): void
    {
        if ($this->channel) {
            $this->currentChannel = Channel::findBySlug($this->channel);
        }
    }

    #[On('channelUpdated')]
    public function reloadThreads(?int $channelId): void
    {
        if ($channelId) {
            $this->currentChannel = Channel::query()->find($channelId);
        } else {
            $this->currentChannel = null;
        }

        $this->resetPage();
        $this->dispatch('render');
    }

    protected function applySearch(Builder $query): Builder
    {
        if ($this->search) {
            return $query->where(function (Builder $query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            });
        }

        return $query;
    }

    protected function applySolved(Builder $query): Builder
    {
        if ($this->solved) {
            // @phpstan-ignore-next-line
            return match ($this->solved) {
                'no' => $query->scopes('unresolved'),
                'yes' => $query->scopes('resolved'),
            };
        }

        return $query;
    }

    protected function applyAuthor(Builder $query): Builder
    {
        if (Auth::check() && $this->user) {
            return $query->whereHas('user', function (Builder $query): void {
                $query->where('user_id', Auth::id());
            });
        }

        return $query;
    }

    protected function applyChannel(Builder $query): Builder
    {
        if ($this->currentChannel?->id) {
            return $query->scopes(['channel' => $this->currentChannel]);
        }

        return $query;
    }

    protected function applySubscribe(Builder $query): Builder
    {
        return $query;
    }

    protected function applyUnAnswer(Builder $query): Builder
    {
        return $query;
    }

    public function render(): View
    {
        $query = Thread::with('channels')
            ->orderByDesc('created_at');

        $query = $this->applyChannel($query);
        $query = $this->applySearch($query);
        $query = $this->applySolved($query);
        $query = $this->applyAuthor($query);
        $query = $this->applySubscribe($query);
        $query = $this->applyUnAnswer($query);

        $threads = $query
            ->scopes('withViewsCount')
            ->paginate($this->perPage);

        return view('livewire.pages.forum.index', [
            'threads' => $threads,
        ])
            ->title(__('pages/forum.channel_title', ['channel' => isset($this->currentChannel) ? ' ~ '.$this->currentChannel->name : '']));
    }
}
