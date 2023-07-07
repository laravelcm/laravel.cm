<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Events\ReplyWasCreated;
use App\Gamify\Points\ReplyCreated;
use App\Models\Reply;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class CreateReply extends Component
{
    use AuthorizesRequests;

    public Thread $thread;

    public string $body = '';

    /**
     * @var string[]
     */
    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    /**
     * @var string[]
     */
    protected $rules = [
        'body' => 'required',
    ];

    public function onMarkdownUpdate(string $content): void
    {
        $this->body = $content;
    }

    public function save(): void
    {
        $this->authorize(ReplyPolicy::CREATE, Reply::class);

        $this->validate();

        $reply = new Reply(['body' => $this->body]);
        $reply->authoredBy(Auth::user()); // @phpstan-ignore-line
        $reply->to($this->thread);
        $reply->save();

        givePoint(new ReplyCreated($this->thread, Auth::user()));

        event(new ReplyWasCreated($reply));

        session()->flash('status', 'Réponse ajoutée avec succès!');

        $this->redirectRoute('forum.show', $this->thread);
    }

    public function render(): View
    {
        return view('livewire.forum.create-reply');
    }
}
