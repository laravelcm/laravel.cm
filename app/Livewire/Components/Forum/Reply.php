<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Gamify\Points\BestReply;
use App\Gamify\Points\ReplyCreated;
use App\Livewire\Traits\HandlesAuthorizationExceptions;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

final class Reply extends Component
{
    use HandlesAuthorizationExceptions;

    public ReplyModel $reply;

    public Thread $thread;

    public function edit(): void
    {
        $this->authorize('update', $this->reply);

        $this->dispatch('replyForm', replyId: $this->reply->id)
            ->to(ReplyForm::class);
    }

    public function confirmDelete(): void
    {
        $this->authorize('delete', $this->reply);

        Flux::modal('confirm-delete-reply-'.$this->reply->id)->show();
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->reply);

        DB::transaction(function (): void {
            /** @var User $replyAuthor */
            $replyAuthor = $this->reply->user;

            $this->reply->delete();

            undoPoint(new ReplyCreated($this->reply, $replyAuthor), $replyAuthor);
        });

        Flux::toast(
            text: __('notifications.reply.deleted'),
            variant: 'success'
        );

        $this->redirectRoute('forum.show', $this->thread, navigate: true);
    }

    public function markAsSolution(): void
    {
        $this->authorize('manage', $this->thread);

        if ($this->thread->isSolved()) {
            undoPoint(new BestReply($this->thread->solutionReply)); // @phpstan-ignore-line
        }

        $this->thread->markSolution($this->reply, Auth::user()); // @phpstan-ignore-line

        givePoint(new BestReply($this->reply));

        Flux::toast(
            text: __('notifications.thread.best_reply'),
            variant: 'success'
        );

        $this->redirect(route('forum.show', $this->thread).$this->reply->getPathUrl(), navigate: true);
    }

    #[On('reply.save.{reply.id}')]
    public function render(): View
    {
        return view('livewire.components.forum.reply');
    }
}
