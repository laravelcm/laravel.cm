<?php

namespace App\Http\Livewire\Forum;

use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reply extends Component
{
    use AuthorizesRequests;

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
    }

    public function delete()
    {

    }

    public function render()
    {
        return view('livewire.forum.reply');
    }
}
