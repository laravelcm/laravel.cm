<?php

declare(strict_types=1);

use App\Actions\Article\ArticleDeleteAction;
use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Discussion;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

new class extends Component implements HasForms, HasActions {

    use WithPagination, WithoutUrlPagination;
    use InteractsWithActions;
    use InteractsWithForms;

    #[Computed]
    public function discussions(): LengthAwarePaginator
    {
        return \App\Models\Discussion::query()
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
                    component: 'components.slideovers.discussion-form',
                    arguments: ['discussionId' => $arguments['discussion']]
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
                $discussion = Discussion::query()->find($arguments['discussion']);

                app(DeleteDiscussionAction::class)->execute($discussion);

                Notification::make()
                    ->success()
                    ->title(__('notifications.discussion.deleted'))
                    ->send();
            });
    }
};
?>

<div>
    <main class="lg:col-span-9">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="font-heading text-lg font-bold leading-7 text-gray-900 sm:truncate sm:text-xl dark:text-white">
                    {{ __('pages/discussion.your_discussion')  }}
                </h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                @can('create', Discussion::class)
                    <x-buttons.primary type="button"
                                       onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
                                       class="gap-2 w-full justify-center py-2.5">
                        {{ __('actions.start') }}
                    </x-buttons.primary>
                @endcan
            </div>
        </div>

        @if ($this->discussions->isNotEmpty())
            <div class="relative mt-5 space-y-4">
                @foreach ($this->discussions as $discussion)
                    <div
                        class="rounded-xl mb-8 p-6 cursor-pointer bg-white transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-gray-800 dark:hover:bg-white/10 lg:py-5 lg:px-6">
                        <x-discussions.overview :discussion="$discussion" :hiddenAuthor="false" :displayButton="true"
                                                class="py-6" />
                    </div>
                @endforeach
            </div>
        @else
            <x-empty-state>
                <div class="relative">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r rotate-3 w-72 from-flag-green to-flag-red rounded-lg blur opacity-25">
                        </div>
                        <div
                            class="relative z-20 bg-white gap-3 rotate-3 p-3 w-72 rounded-lg shadow ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                            <div class="space-y-2">
                                <div class="grid grid-cols-3 gap-2 w-1/3">
                                    <div
                                        class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800">
                                    </div>
                                    <div
                                        class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800">
                                    </div>
                                </div>
                                <div
                                    class="h-4 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800">
                                </div>
                                <div
                                    class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute transform scale-[0.8] bottom-10 right-2 shadow w-40 -rotate-6 z-20 bg-white gap-3 p-3 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                        <div class="space-y-2">
                            <div class="grid grid-cols-3 gap-2 w-2/3">
                                <div
                                    class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800">
                                </div>
                                <div
                                    class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800">
                                </div>
                            </div>
                            <div
                                class="h-2 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800">
                            </div>
                            <div
                                class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 space-y-4">
                    <p class="mt-8 text-base text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $this->user->name }}</span>
                        {{ __('pages/account.activities.empty_discussions') }}
                    </p>

                    @if ($this->user->isLoggedInUser())
                        @can('create', \App\Models\Thread::class)
                            <x-buttons.primary type="button"
                                               onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })">
                                <x-untitledui-message-text-square class="size-5" aria-hidden="true" />
                                {{ __('global.launch_modal.discussion_action') }}
                            </x-buttons.primary>
                        @endcan
                    @endif
                </div>
            </x-empty-state>
        @endif
        <div class="mt-4">
            {{ $this->discussions->links() }}
        </div>
    </main>
</div>
