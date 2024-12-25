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

    use WithPagination, WithoutUrlPagination;
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
        return <<<'HTML'
            <div class="rounded-xl mb-8 p-6 bg-white transition duration-200 ease-in-out dark:bg-gray-800 animate-pulse">

                <div class="flex items-center space-x-2 mb-4">
                    <div class="h-7 w-20 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    <div class="h-7 w-24 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                </div>

                <div class="h-7 w-3/4 bg-gray-200 dark:bg-gray-700 rounded-lg mb-4"></div>

                <div class="space-y-2">
                    <div class="h-4 w-full bg-gray-200 dark:bg-gray-700 rounded"></div>
                    <div class="h-4 w-5/6 bg-gray-200 dark:bg-gray-700 rounded"></div>
                </div>

                <div class="mt-4 sm:flex sm:justify-between">
                    <div class="flex items-center">
                        <div class="h-6 w-6 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        <div class="ml-2 h-4 w-40 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>

                    <div class="hidden sm:flex sm:items-center">
                        <div class="h-4 w-16 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('warning')
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
