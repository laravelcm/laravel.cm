<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.forum')]
final class DetailThread extends Component
{
    public Thread $thread;

    public function mount(Thread $thread): void
    {
        $this->thread = $thread->load('replies.user', 'replies', 'latestReply');
        views($thread)->record();
    }

    public function render(): View
    {
        return view('livewire.pages.forum.detail-thread')
            ->title($this->thread->subject());
    }
}
