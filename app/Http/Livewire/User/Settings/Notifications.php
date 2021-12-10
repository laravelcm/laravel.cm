<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Subscribe;
use App\Policies\DiscussionPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Notifications extends Component
{
    use Actions, AuthorizesRequests;

    public $subscribeId;

    public function unsubscribe(string $subscribeId)
    {
        $this->subscribeId = $subscribeId;

        $this->subscribe->delete();

        $this->notification()->success('Désabonnement', 'Vous êtes maintenant désabonné de cet fil.');
    }

    public function getSubscribeProperty(): Subscribe
    {
        return Subscribe::where('uuid', $this->subscribeId)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.user.settings.notifications', [
            'subscriptions' => Auth::user()->subscriptions,
        ]);
    }
}
