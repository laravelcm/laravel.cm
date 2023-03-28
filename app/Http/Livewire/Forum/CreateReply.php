<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Events\ReplyWasCreated;
use App\Gamify\Points\ReplyCreated;
use App\Models\Reply;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateReply extends Component
{
    use AuthorizesRequests;

    public Thread $thread;

    public string $body = '';

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'body' => 'required',
    ];

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function save()
    {
        $this->authorize(ReplyPolicy::CREATE, Reply::class);

        $this->validate();

        $reply = new Reply(['body' => $this->body]);
        $reply->authoredBy(Auth::user());
        $reply->to($this->thread);
        $reply->save();

        givePoint(new ReplyCreated($this->thread, Auth::user()));

        event(new ReplyWasCreated($reply));

        session()->flash('status', 'Réponse ajoutée avec succès!');

        $this->redirectRoute('forum.show', $this->thread);
    }

    public function render()
    {
        return view('livewire.forum.create-reply');
    }
}
