<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Forum;

use App\Gamify\Points\ThreadCreated;
use App\Models\Thread;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.forum')]
final class DetailThread extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Thread $thread;

    public function mount(Thread $thread): void
    {
        views($thread)->cooldown(now()->addHour())->record();

        $this->thread = $thread->loadCount('views');
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->authorize('update', $this->thread)
            ->action(
                fn () => $this->dispatch(
                    'openPanel',
                    component: 'components.slideovers.thread-form',
                    arguments: ['threadId' => $this->thread->id]
                )
            );
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('actions.delete'))
            ->color('danger')
            ->authorize('delete', $this->thread)
            ->requiresConfirmation()
            ->action(function (): void {
                DB::beginTransaction();

                undoPoint(new ThreadCreated($this->thread));
                $this->thread->delete();

                DB::commit();

                $this->redirectRoute('forum.index', navigate: true);
            });
    }

    #[On('thread.save.{thread.id}')]
    public function render(): View
    {
        return view('livewire.pages.forum.detail-thread')
            ->title($this->thread->subject());
    }
}
