<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Actions\Subscription\SubscribeToFeedAction;
use App\Actions\Subscription\UnsubscribeToFeedAction;
use App\Models\Thread;
use Flux\Flux;
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

        resolve(SubscribeToFeedAction::class)->execute($this->thread);

        Flux::toast(
            text: __('notifications.thread.subscribe'),
            variant: 'success',
        );

        $this->dispatch('subscription.update')->self();
    }

    public function unsubscribe(): void
    {
        $this->authorize('unsubscribe', $this->thread);

        /** @var string $uuid */
        $uuid = $this->thread->subscribes()
            ->where('user_id', Auth::id())
            ->firstOrFail()->uuid;

        resolve(UnsubscribeToFeedAction::class)->execute($uuid);

        Flux::toast(
            text: __('notifications.thread.unsubscribe'),
            variant: 'success',
        );

        $this->dispatch('subscription.update')->self();
    }

    #[On('subscription.update')]
    public function render(): View
    {
        return view('livewire.components.forum.subscribe');
    }
}
