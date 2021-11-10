<?php

namespace App\Http\Livewire\Forum;

use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Reply extends Component
{
    use Actions, AuthorizesRequests;

    public ReplyModel $reply;
    public Thread $thread;

    protected $listeners = ['refresh' => '$refresh'];

    public function edit()
    {
    }

    public function markAsSolution(): void
    {
        $this->authorize(ThreadPolicy::UPDATE, $this->thread);

        $this->thread->markSolution($this->reply, Auth::user());

        $this->emitSelf('refresh');

        $this->notification()->success(
            'Réponse acceptée',
            'Vous avez accepté cette solution pour ce sujet.'
        );
    }

    public function delete()
    {
    }

    public function render()
    {
        return view('livewire.forum.reply');
    }
}
