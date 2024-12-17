<?php

declare(strict_types=1);

namespace App\Livewire\Components\Discussion;

use App\Actions\Replies\LikeReply;
use App\Models\Reply;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
final class Comment extends Component
{
    public Reply $comment;

    public function delete(): void
    {
        $this->comment->delete();

        Notification::make()
            ->title(__('notifications.discussion.delete_comment'))
            ->success()
            ->send();

        $this->dispatch('comments.change');
    }

    public function toggleLike(): void
    {
        $this->authorize('like', $this->comment);

        app()->call(LikeReply::class, [
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
