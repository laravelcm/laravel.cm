<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Models\Subscribe as SubscribeModel;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

final class Subscribe extends Component
{
    use AuthorizesRequests;

    public Thread $thread;

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh'];

    public function subscribe(): void
    {
        $this->authorize(ThreadPolicy::SUBSCRIBE, $this->thread);

        $subscribe = new SubscribeModel();
        $subscribe->uuid = Uuid::uuid4()->toString();
        $subscribe->user()->associate(Auth::user());
        $this->thread->subscribes()->save($subscribe);

        Notification::make()
            ->title(__('Abonnement'))
            ->body(__('Vous êtes maintenant abonné à ce sujet.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->emitSelf('refresh');
    }

    public function unsubscribe(): void
    {
        $this->authorize(ThreadPolicy::UNSUBSCRIBE, $this->thread);

        $this->thread->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        Notification::make()
            ->title(__('Désabonnement'))
            ->body(__('Vous vous êtes désabonné de ce sujet.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->emitSelf('refresh');
    }

    public function render(): View
    {
        return view('livewire.forum.subscribe');
    }
}
