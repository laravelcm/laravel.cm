<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Gamify\Points\BestReply;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reply extends Component
{
    use AuthorizesRequests;

    public ReplyModel $reply;

    public Thread $thread;

    public string $body = '';

    public bool $isUpdating = false;

    protected $listeners = [
        'refresh' => '$refresh',
        'editor:update' => 'onEditorUpdate',
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

    public function onEditorUpdate(string $body)
    {
        $this->body = $body;
    }

    public function edit()
    {
        $this->authorize(ReplyPolicy::UPDATE, $this->reply);

        $this->validate();

        $this->reply->update(['body' => $this->body]);

        // @ToDo mettre un nouveau system de notification
//        $this->notification()->success(
//            'Réponse modifié',
//            'Vous avez modifié cette solution avec succès.'
//        );

        $this->isUpdating = false;

        $this->emitSelf('refresh');
    }

    public function UnMarkAsSolution(): void
    {
        $this->authorize(ThreadPolicy::UPDATE, $this->thread);

        undoPoint(new BestReply($this->reply));

        $this->thread->unmarkSolution();

        $this->emitSelf('refresh');

        // @ToDo mettre un nouveau system de notification
//        $this->notification()->success(
//            'Réponse acceptée',
//            'Vous avez retiré cette réponse comme solution pour ce sujet.'
//        );
    }

    public function markAsSolution(): void
    {
        $this->authorize(ThreadPolicy::UPDATE, $this->thread);

        if ($this->thread->isSolved()) {
            undoPoint(new BestReply($this->thread->solutionReply));
        }

        $this->thread->markSolution($this->reply, Auth::user());

        givePoint(new BestReply($this->reply));

        $this->emitSelf('refresh');

        // @ToDo mettre un nouveau system de notification
//        $this->notification()->success(
//            'Réponse acceptée',
//            'Vous avez accepté cette solution pour ce sujet.'
//        );
    }

    public function render(): View
    {
        return view('livewire.forum.reply');
    }
}
