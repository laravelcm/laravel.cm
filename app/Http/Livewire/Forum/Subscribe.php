<?php

namespace App\Http\Livewire\Forum;

use App\Models\Subscribe as SubscribeModel;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use WireUi\Traits\Actions;

class Subscribe extends Component
{
    use Actions, AuthorizesRequests;

    public Thread $thread;

    protected $listeners = ['refresh' => '$refresh'];

    public function subscribe()
    {
        $this->authorize(ThreadPolicy::SUBSCRIBE, $this->thread);

        $subscribe = new SubscribeModel();
        $subscribe->uuid = Uuid::uuid4()->toString();
        $subscribe->user()->associate(Auth::user());
        $this->thread->subscribes()->save($subscribe);

        $this->notification()->success('Abonnement', 'Vous êtes maintenant abonné à ce sujet.');
        $this->emitSelf('refresh');
    }

    public function unsubscribe()
    {
        $this->authorize(ThreadPolicy::UNSUBSCRIBE, $this->thread);

        $this->thread->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        $this->notification()->success('Désabonnement', 'Vous êtes maintenant désabonné de ce sujet.');
        $this->emitSelf('refresh');
    }

    public function render()
    {
        return view('livewire.forum.subscribe');
    }
}
