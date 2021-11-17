<?php

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Subscribe as SubscribeModel;
use App\Policies\DiscussionPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use WireUi\Traits\Actions;

class Subscribe extends Component
{
    use Actions, AuthorizesRequests;

    public Discussion $discussion;

    protected $listeners = ['refresh' => '$refresh'];

    public function subscribe()
    {
        $this->authorize(DiscussionPolicy::SUBSCRIBE, $this->discussion);

        $subscribe = new SubscribeModel();
        $subscribe->uuid = Uuid::uuid4()->toString();
        $subscribe->user()->associate(Auth::user());
        $this->discussion->subscribes()->save($subscribe);

        $this->notification()->success('Abonnement', 'Vous êtes maintenant abonné à cette discussion.');
        $this->emitSelf('refresh');
    }

    public function unsubscribe()
    {
        $this->authorize(DiscussionPolicy::UNSUBSCRIBE, $this->discussion);

        $this->discussion->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        $this->notification()->success('Désabonnement', 'Vous êtes maintenant désabonné de cette discussion.');
        $this->emitSelf('refresh');
    }

    public function render()
    {
        return view('livewire.discussions.subscribe');
    }
}
