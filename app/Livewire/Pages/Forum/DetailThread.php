<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Actions\Forum\DeleteThreadAction;
use App\Livewire\Traits\HandlesAuthorizationExceptions;
use App\Models\Thread;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.forum')]
final class DetailThread extends Component
{
    use HandlesAuthorizationExceptions;

    public Thread $thread;

    public function mount(): void
    {
        views($this->thread)
            ->cooldown(now()->addHour())
            ->record();

        $this->thread->load('channels', 'channels.parent', 'user', 'user.media', 'replies', 'solutionReply')
            ->loadCount('views');
    }

    public function edit(): void
    {
        $this->authorize('update', $this->thread);

        $this->dispatch(
            'openPanel',
            component: 'components.slideovers.thread-form',
            arguments: ['threadId' => $this->thread->id]
        );
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->thread);

        Flux::modal('confirm-delete-thread')->show();
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->thread);

        resolve(DeleteThreadAction::class)->execute($this->thread);

        Flux::toast(
            text: __('notifications.thread.deleted'),
            variant: 'success'
        );

        $this->redirectRoute('forum.index', navigate: true);
    }

    #[On('thread.save.{thread.id}')]
    public function render(): View
    {
        return view('livewire.pages.forum.detail-thread')
            ->title($this->thread->subject());
    }
}
