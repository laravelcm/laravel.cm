<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

new class extends Component {

    use WithPagination, WithoutUrlPagination;

    #[Computed]
    public function discussions(): LengthAwarePaginator
    {
        return \App\Models\Discussion::query()
            ->where('user_id', Auth::id())
            ->with(['user'])
            ->latest()
            ->paginate(3);
    }

    public function placeholder()
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
};
?>

<div>
    <main class="lg:col-span-9">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="font-heading text-lg font-bold leading-7 text-gray-900 sm:truncate sm:text-xl">
                    {{ __('pages/discussion.your_discussion')  }}
                </h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                @can('create', \App\Models\Discussion::class)
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
                    <x-discussions.overview :discussion="$discussion" :hiddenAuthor="false" />
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
