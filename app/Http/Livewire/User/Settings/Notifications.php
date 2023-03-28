<?php

declare(strict_types=1);

namespace App\Http\Livewire\User\Settings;

use App\Models\Subscribe;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    use AuthorizesRequests;

    public $subscribeId;

    public function unsubscribe(string $subscribeId)
    {
        $this->subscribeId = $subscribeId;

        // @phpstan-ignore-next-line
        $this->subscribe->delete();

        // @ToDo mettre un nouveau system de notification
        // $this->notification()->success('Désabonnement', 'Vous êtes maintenant désabonné de cet fil.');
    }

    public function getSubscribeProperty(): Subscribe
    {
        return Subscribe::where('uuid', $this->subscribeId)->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.user.settings.notifications', [
            'subscriptions' => Auth::user()->subscriptions,
        ]);
    }
}
