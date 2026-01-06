<?php

declare(strict_types=1);

namespace App\Livewire\Components\Discussion;

use App\Actions\Discussion\LikeReplyAction;
use App\Gamify\Points\ReplyCreated;
use App\Livewire\Traits\HandlesAuthorizationExceptions;
use App\Models\Reply;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
final class Comment extends Component
{
    use HandlesAuthorizationExceptions;

    public Reply $comment;

    public function delete(): void
    {
        DB::transaction(function (): void {
            /** @var User $commentAuthor */
            $commentAuthor = $this->comment->user;

            $this->comment->delete();

            $commentAuthor->undoPoint(new ReplyCreated($this->comment, $commentAuthor));
        });

        Flux::toast(
            text: __('notifications.discussion.delete_comment'),
            variant: 'success'
        );

        $this->dispatch('comments.change');
    }

    public function toggleLike(): void
    {
        $this->authorize('like', $this->comment);

        app()->call(LikeReplyAction::class, [
            'user' => auth()->user(),
            'reply' => $this->comment,
        ]);
    }

    public function placeholder(): View
    {
        return view('components.skeletons.comment');
    }

    public function render(): View
    {
        return view('livewire.components.discussion.comment', [
            'count' => $this->comment->getReactionsSummary()->sum('count'),
        ]);
    }
}
