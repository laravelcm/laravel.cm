<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Actions\Forum\SubscribeToThreadAction;
use App\Models\Thread;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

final class Subscribe extends Component
{
    public Thread $thread;

    public function subscribe(): void
    {
        $this->authorize('subscribe', $this->thread);

        resolve(SubscribeToThreadAction::class)->execute($this->thread);

        Notification::make()
            ->title(__('notifications.thread.subscribe'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('subscription.update')->self();
    }

    public function unsubscribe(): void
    {
        $this->authorize('unsubscribe', $this->thread);

        $this->thread->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        Notification::make()
            ->title(__('notifications.thread.unsubscribe'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('subscription.update')->self();
    }

    #[On('subscription.update')]
    public function render(): View
    {
        return view('livewire.components.forum.subscribe');
    }
}
