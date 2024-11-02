<?php

declare(strict_types=1);

namespace App\Livewire\Forum;

use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Gamify\Points\BestReply;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

final class Reply extends Component
{
    public ReplyModel $reply;

    public Thread $thread;

    public function edit(): void
    {
        $this->authorize('update', $this->reply);

        $this->validate();

        // $this->reply->update(['body' => $this->body]);

        Notification::make()
            ->title(__('Réponse modifiée'))
            ->body(__('Vous avez modifié cette solution avec succès.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('reply.updated');
    }

    /**
     * @throws CouldNotMarkReplyAsSolution
     */
    public function markAsSolution(): void
    {
        $this->authorize('manage', $this->thread);

        if ($this->thread->isSolved()) {
            undoPoint(new BestReply($this->thread->solutionReply));
        }

        $this->thread->markSolution($this->reply, Auth::user()); // @phpstan-ignore-line

        givePoint(new BestReply($this->reply));

        Notification::make()
            ->title(__('notifications.thread.best_reply'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('thread.save.{$thread->id}');
    }

    #[On('reply.updated')]
    public function render(): View
    {
        return view('livewire.forum.reply');
    }
}
