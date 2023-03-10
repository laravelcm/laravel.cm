<?php

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Subscribe as SubscribeModel;
use App\Policies\DiscussionPolicy;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class Subscribe extends Component
{
    use AuthorizesRequests;

    public Discussion $discussion;

    protected $listeners = ['refresh' => '$refresh'];

    public function subscribe()
    {
        $this->authorize(DiscussionPolicy::SUBSCRIBE, $this->discussion);

        $subscribe = new SubscribeModel();
        $subscribe->uuid = Uuid::uuid4()->toString();
        $subscribe->user()->associate(Auth::user());
        $this->discussion->subscribes()->save($subscribe);

        Notification::make()
            ->title(__('Abonnement'))
            ->body(__('Vous êtes maintenant abonné à cette discussion.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->emitSelf('refresh');
    }

    public function unsubscribe()
    {
        $this->authorize(DiscussionPolicy::UNSUBSCRIBE, $this->discussion);

        $this->discussion->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        Notification::make()
            ->title(__('Désabonnement'))
            ->body(__('Vous êtes maintenant désabonné à cette discussion.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->emitSelf('refresh');
    }

    public function render(): View
    {
        return view('livewire.discussions.subscribe');
    }
}
