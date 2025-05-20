<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use App\Models\Thread;
use App\Traits\WithLocale;
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
    use WithLocale;
    use WithoutUrlPagination;
    use WithPagination;

    #[Url]
    public ?string $channel = null;

    #[Url]
    public ?string $solved = null;

    #[Url(as: 'me')]
    public ?string $user = null;

    #[Url(as: 'no-replies')]
    public ?string $unAnswered = null;

    #[Url(as: 'follow')]
    public ?string $subscribe = null;

    #[Url]
    public ?string $popular = null;

    public ?Channel $currentChannel = null;

    public string $search = '';

    public int $perPage = 30;

    public function mount(): void
    {
        if (! blank($this->channel)) {
            $this->currentChannel = Channel::findBySlug($this->channel);
        }
    }

    #[On('channelUpdated')]
    public function reloadThreads(?int $channelId): void
    {
        $this->currentChannel = filled($channelId) ? Channel::query()->find($channelId) : null;

        $this->resetPage();

        $this->dispatch('render');
    }

    #[On('redirectToLogin')]
    public function redirectToLogin(): void
    {
        $this->redirectRoute('login', navigate: true);
    }

    protected function applyPopular(Builder $query): Builder
    {
        if (! blank($this->popular)) {
            return $query // @phpstan-ignore-line
                ->withCount('replies')
                ->orderByDesc('replies_count')
                ->OrderByViews();
        }

        return $query;
    }

    protected function applySearch(Builder $query): Builder
    {
        if (! blank($this->search)) {
            return $query->where(function (Builder $query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            });
        }

        return $query;
    }

    protected function applySolved(Builder $query): Builder
    {
        if (filled($this->solved)) {
            // @phpstan-ignore-next-line
            return match ($this->solved) {
                'no' => $query->scopes('unresolved'),
                'yes' => $query->scopes('resolved'),
            };
        }

        return $query;
    }

    protected function applyLocale(Builder $query): Builder
    {
        if (filled($this->locale)) {
            $query->forLocale($this->locale); // @phpstan-ignore-line
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
        if (Auth::check() && $this->subscribe) {
            $query->whereHas('subscribes', function (Builder $query): void {
                $query->where('user_id', Auth::id());
            });
        }

        return $query;
    }

    protected function applyUnAnswer(Builder $query): Builder
    {
        if (filled($this->unAnswered)) {
            return $query->whereDoesntHave('replies');
        }

        return $query;
    }

    protected function applySorting(Builder $query): Builder
    {
        return filled($this->popular)
            ? $this->applyPopular($query)
            : $query->orderByDesc('created_at');
    }

    public function render(): View
    {
        $query = Thread::with(['channels', 'channels.parent', 'user', 'user.media'])
            ->withCount('replies');

        $query = $this->applyChannel($query);
        $query = $this->applySearch($query);
        $query = $this->applySolved($query);
        $query = $this->applyLocale($query);
        $query = $this->applyAuthor($query);
        $query = $this->applySubscribe($query);
        $query = $this->applyUnAnswer($query);
        $query = $this->applySorting($query);

        $threads = $query
            ->scopes('withViewsCount')
            ->paginate($this->perPage);

        return view('livewire.pages.forum.index', [
            'threads' => $threads,
        ])
            ->title(__('pages/forum.channel_title', ['channel' => filled($this->currentChannel) ? ' ~ '.$this->currentChannel->name : '']));
    }
}
