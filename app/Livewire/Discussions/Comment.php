<?php

declare(strict_types=1);

namespace App\Livewire\Discussions;

use App\Actions\Replies\LikeReply;
use App\Models\Reply;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Comment extends Component
{
    public Reply $comment;

    public function delete(): void
    {
        $this->comment->delete();

        Notification::make()
            ->title(__('Votre commentaire a été supprimé.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('reloadComment');
    }

    public function toggleLike(): void
    {
        if (! Auth::check()) {
            Notification::make()
                ->title(__('Vous devez être connecté pour liker un commentaire.'))
                ->danger()
                ->duration(5000)
                ->send();

            return;
        }

        app(LikeReply::class)->handle(auth()->user(), $this->comment);

        $this->dispatch('reloadComment')->self();
    }

    public function render(): View
    {
        return view('livewire.discussions.comment', [
            'count' => $this->comment->getReactionsSummary()->sum('count'),
        ]);
    }
}
