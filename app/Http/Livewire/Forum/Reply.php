<?php

declare(strict_types=1);

namespace App\Http\Livewire\Forum;

use App\Gamify\Points\BestReply;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Reply extends Component
{
    use AuthorizesRequests;

    public ReplyModel $reply;

    public Thread $thread;

    public string $body = '';

    public bool $isUpdating = false;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'editor:update' => 'onEditorUpdate',
    ];

    /**
     * @var string[]
     */
    protected $rules = [
        'body' => 'required',
    ];

    public function mount(ReplyModel $reply, Thread $thread): void
    {
        $this->thread = $thread;
        $this->reply = $reply;
        $this->body = $reply->body;
    }

    public function onEditorUpdate(string $body): void
    {
        $this->body = $body;
    }

    public function edit(): void
    {
        $this->authorize(ReplyPolicy::UPDATE, $this->reply);

        $this->validate();

        $this->reply->update(['body' => $this->body]);

        Notification::make()
            ->title(__('Réponse modifiée'))
            ->body(__('Vous avez modifié cette solution avec succès.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->isUpdating = false;

        $this->emitSelf('refresh');
    }

    public function UnMarkAsSolution(): void
    {
        $this->authorize(ThreadPolicy::UPDATE, $this->thread);

        undoPoint(new BestReply($this->reply));

        $this->thread->unmarkSolution();

        $this->emitSelf('refresh');

        Notification::make()
            ->title(__('Réponse rejetée'))
            ->body(__('Vous avez retiré cette réponse comme solution pour ce sujet.'))
            ->success()
            ->duration(5000)
            ->send();
    }

    public function markAsSolution(): void
    {
        $this->authorize(ThreadPolicy::UPDATE, $this->thread);

        if ($this->thread->isSolved()) {
            undoPoint(new BestReply($this->thread->solutionReply));
        }

        $this->thread->markSolution($this->reply, Auth::user()); // @phpstan-ignore-line

        givePoint(new BestReply($this->reply));

        $this->emitSelf('refresh');

        Notification::make()
            ->title(__('Réponse acceptée'))
            ->body(__('Vous avez accepté cette solution pour ce sujet.'))
            ->success()
            ->duration(5000)
            ->send();
    }

    public function render(): View
    {
        return view('livewire.forum.reply');
    }
}
