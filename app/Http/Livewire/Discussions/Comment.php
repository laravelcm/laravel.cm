<?php

namespace App\Http\Livewire\Discussions;

use App\Actions\Replies\LikeReply;
use App\Models\Reply;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Comment extends Component
{
    public Reply $comment;

    protected $listeners = ['reloadComment' => '$refresh'];

    public function delete(): void
    {
        $this->comment->delete();

        Notification::make()
            ->title(__('Votre commentaire a été supprimé.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->emitUp('reloadComment');
    }

    public function toggleLike(): void
    {
        LikeReply::run(auth()->user(), $this->comment);

        $this->emitSelf('reloadComment');
    }

    public function render(): View
    {
        return view('livewire.discussions.comment', [
            'count' => $this->comment->getReactionsSummary()->sum('count'),
        ]);
    }
}
