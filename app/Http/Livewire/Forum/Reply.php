<?php

namespace App\Http\Livewire\Forum;

use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
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
    public string $body = '';
    public bool $isUpdating = false;

    protected $listeners = [
        'refresh' => '$refresh',
        'markdown-x:update' => 'onMarkdownUpdate'
    ];

    protected $rules = [
        'body' => 'required',
    ];

    public function mount(ReplyModel $reply, Thread $thread)
    {
        $this->thread = $thread;
        $this->reply = $reply;
        $this->body = $reply->body;
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function edit()
    {
        $this->authorize(ReplyPolicy::UPDATE, $this->reply);

        $this->validate();

        $this->reply->update(['body' => $this->body]);

        $this->notification()->success(
            'Réponse modifié',
            'Vous avez modifié cette solution avec succès.'
        );

        $this->isUpdating = false;

        $this->emitSelf('refresh');
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

    public function render()
    {
        return view('livewire.forum.reply');
    }
}
