<?php

use App\Actions\Forum\DeleteThreadAction;
use App\Models\Thread;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

new class extends Component implements HasForms, HasActions {

    use WithPagination;
    use WithoutUrlPagination;
    use InteractsWithActions;
    use InteractsWithForms;

    #[Computed]
    public function threads(): LengthAwarePaginator
    {
        return Thread::query()
            ->where('user_id', Auth::id())
            ->with(['user'])
            ->latest()
            ->paginate(10);
    }

    public function placeholder(): string
    {
        return view('components.skeletons.account');
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->action(
                fn(array $arguments) => $this->dispatch(
                    'openPanel',
                    component: 'components.slideovers.thread-form',
                    arguments: ['threadId' => $arguments['thread']]
                )
            );
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('actions.delete'))
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                $thread = Thread::query()->find($arguments['thread']);

                app(DeleteThreadAction::class)->execute($thread);

                Notification::make()
                    ->success()
                    ->title(__('notifications.thread.deleted'))
                    ->send();
            });
    }
}; ?>

<div>
    <main class="lg:col-span-9">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="font-heading text-lg font-bold leading-7 text-gray-900 sm:truncate sm:text-xl dark:text-white">
                    {{ __('pages/forum.your_thread') }}
                </h2>
            </div>

            @can('create', Thread::class)
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <x-buttons.primary class="justify-items-center" type="button"
                                       onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })">
                        <x-untitledui-message-text-square class="size-5 mr-2" aria-hidden="true" />
                        {{ __('global.launch_modal.forum_action') }}
                    </x-buttons.primary>
                </div>
            @endcan

        </div>

        <div class="mt-5 space-y-4">
            @forelse ($this->threads as $thread)
                <x-forum.thread :thread="$thread" />
            @empty
                <p class="text-base text-gray-500 dark:text-gray-400">{{ __('pages/thread.not_thread_created') }}.</p>
            @endforelse

            <div class="pt-5">
                {{ $this->threads->links() }}
            </div>
        </div>
    </main>
</div>
