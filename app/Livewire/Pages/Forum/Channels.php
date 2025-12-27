<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.forum')]
final class Channels extends Component
{
    /**
     * @return Collection<int, Channel>
     */
    #[Computed(persist: true, seconds: 3600 * 7 * 20)]
    public function channels(): Collection
    {
        return Channel::query()
            ->withCount('threads')
            ->whereNull('parent_id')
            ->get()
            ->sortByDesc('threads_count');
    }

    /**
     * @return Collection<int, Channel>
     */
    #[Computed(persist: true, seconds: 3600 * 7 * 20)]
    public function childChannels(): Collection
    {
        return Channel::query()
            ->withCount('threads')
            ->whereNotNull('parent_id')
            ->get()
            ->sortByDesc('threads_count');
    }

    public function render(): View
    {
        return view('livewire.pages.forum.channels')
            ->title(__('pages/forum.navigation.channels'));
    }
}
