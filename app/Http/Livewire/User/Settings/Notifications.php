<?php

declare(strict_types=1);

namespace App\Http\Livewire\User\Settings;

use App\Models\Subscribe;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Notifications extends Component
{
    use AuthorizesRequests;

    public string $subscribeId;

    public function unsubscribe(string $subscribeId): void
    {
        $this->subscribeId = $subscribeId;

        // @phpstan-ignore-next-line
        $this->subscribe->delete();

        Notification::make()
            ->title(__('Désabonnement'))
            ->body(__('Vous êtes maintenant désabonné de cet fil.'))
            ->success()
            ->duration(5000)
            ->send();
    }

    public function getSubscribeProperty(): Subscribe
    {
        return Subscribe::where('uuid', $this->subscribeId)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.user.settings.notifications', [
            'subscriptions' => Auth::user()->subscriptions, // @phpstan-ignore-line
        ]);
    }
}
