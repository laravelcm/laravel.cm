<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.forum')]
final class Channels extends Component
{
    public function render(): View
    {
        return view('livewire.pages.forum.channels', [
            'channels' => Channel::query()
                ->withCount('threads')
                ->whereNull('parent_id')
                ->get()
                ->sortByDesc('threads_count'),
            'childChannels' => Channel::query()
                ->withCount('threads')
                ->whereNotNull('parent_id')
                ->get()
                ->sortByDesc('threads_count'),
        ])
            ->title(__('pages/forum.navigation.channels'));
    }
}
