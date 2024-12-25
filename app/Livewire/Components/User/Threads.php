<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Actions\Forum\DeleteThreadAction;
use App\Models\Thread;
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
final class Threads extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithoutUrlPagination;
    use WithPagination;

    #[Computed]
    public function threads(): LengthAwarePaginator
    {
        return Thread::with('user')
            ->scopes('withViewsCount')
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
                    component: 'components.slideovers.thread-form',
                    arguments: ['threadId' => $arguments['id']]
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
                /** @var Thread $thread */
                $thread = Thread::query()->find($arguments['thread']);

                $this->authorize('delete', $thread);

                app(DeleteThreadAction::class)->execute($thread);

                Notification::make()
                    ->success()
                    ->title(__('notifications.thread.deleted'))
                    ->send();
            });
    }

    public function render(): View
    {
        return view('livewire.components.user.threads');
    }
}
