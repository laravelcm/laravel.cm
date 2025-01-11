<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Discussion;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Lazy]
final class Discussions extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithoutUrlPagination;
    use WithPagination;

    #[Computed]
    public function discussions(): LengthAwarePaginator
    {
        return Discussion::with('tags', 'replies')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function placeholder(): View
    {
        return view('components.skeletons.discussions');
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->badge()
            ->action(
                fn (array $arguments) => $this->dispatch(
                    'openPanel',
                    component: 'components.slideovers.discussion-form',
                    arguments: ['discussionId' => $arguments['id']]
                )
            );
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('actions.delete'))
            ->color('danger')
            ->badge()
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                /** @var Discussion $discussion */
                $discussion = Discussion::query()->find($arguments['id']);

                $this->authorize('delete', $discussion);

                app(DeleteDiscussionAction::class)->execute($discussion);

                Notification::make()
                    ->success()
                    ->title(__('notifications.discussion.deleted'))
                    ->send();
            });
    }

    public function render(): View
    {
        return view('livewire.components.user.discussions');
    }
}
