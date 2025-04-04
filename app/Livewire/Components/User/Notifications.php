<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\Subscribe;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property Subscribe $subscribe
 */
final class Notifications extends Component
{
    public ?string $subscribeId = null;

    public function unsubscribe(string $subscribeId): void
    {
        $this->subscribeId = $subscribeId;

        $this->subscribe->delete();

        Notification::make()
            ->title(__('Désabonnement'))
            ->body(__('Vous êtes maintenant désabonné de cet fil.'))
            ->success()
            ->duration(3500)
            ->send();
    }

    #[Computed]
    public function subscribe(): Subscribe
    {
        return Subscribe::query()->where('uuid', $this->subscribeId)->firstOrFail();
    }

    public function redirectToSubscription(int $id, string $type): void
    {
        $subscribe = Subscribe::query()
            ->where('subscribeable_id', $id)
            ->where('subscribeable_type', $type)
            ->firstOrFail();

        $this->redirect(route_to_reply_able($subscribe->subscribeAble), navigate: true); // @phpstan-ignore-line
    }

    public function render(): View
    {
        return view('livewire.components.user.notifications', [
            'subscriptions' => Auth::user()->subscriptions, // @phpstan-ignore-line
        ]);
    }
}
