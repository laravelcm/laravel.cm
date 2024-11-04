<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Gamify\Points\BestReply;
use App\Models\Reply as ReplyModel;
use App\Models\Thread;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

final class Reply extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ReplyModel $reply;

    public Thread $thread;

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->authorize('update', $this->reply)
            ->action(
                fn () => $this->dispatch(
                    'replyForm',
                    replyId: $this->reply->id
                )->to(ReplyForm::class)
            );
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('actions.delete'))
            ->color('danger')
            ->authorize('delete', $this->reply)
            ->requiresConfirmation()
            ->action(function (): void {
                $this->reply->delete();

                $this->redirectRoute('forum.show', $this->thread, navigate: true);
            });
    }

    public function solutionAction(): Action
    {
        return Action::make('solution')
            ->label(__('pages/forum.mark_answer'))
            ->color('success')
            ->authorize('manage', $this->thread)
            ->action(function (): void {
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

                $this->redirect(route('forum.show', $this->thread).$this->reply->getPathUrl(), navigate: true);
            });
    }

    #[On('reply.save.{reply.id}')]
    public function render(): View
    {
        return view('livewire.components.forum.reply');
    }
}
