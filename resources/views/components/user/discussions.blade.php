@props([
    'user',
    'discussions',
])

@if ($discussions->isNotEmpty())
    <div class="relative -mt-6 divide-y divide-gray-200 dark:divide-white/20">
        @foreach ($discussions as $discussion)
            <x-discussions.overview :discussion="$discussion" :with-author="false" />
        @endforeach
    </div>
@else
    <x-empty-state>
        <div class="relative">
            <div class="relative">
                <div class="absolute -inset-1 bg-gradient-to-r rotate-3 w-72 from-flag-green to-flag-red rounded-lg blur opacity-25"></div>
                <div class="relative z-20 bg-white gap-3 rotate-3 p-3 w-72 rounded-lg shadow ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                    <div class="space-y-2">
                        <div class="grid grid-cols-3 gap-2 w-1/3">
                            <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                            <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                        </div>
                        <div class="h-4 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                        <div class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                    </div>
                </div>
            </div>
            <div class="absolute transform scale-[0.8] bottom-10 right-2 shadow w-40 -rotate-6 z-20 bg-white gap-3 p-3 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                <div class="space-y-2">
                    <div class="grid grid-cols-3 gap-2 w-2/3">
                        <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                        <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                    </div>
                    <div class="h-2 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                    <div class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                </div>
            </div>
        </div>
        <div class="mt-8 space-y-4">
            <p class="mt-8 text-base text-gray-500 dark:text-gray-400">
                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                {{ __('pages/account.activities.empty_discussions') }}
            </p>

            @if ($user->isLoggedInUser())
                @can('create', \App\Models\Discussion::class)
                    <x-buttons.primary
                        type="button"
                        onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
                    >
                        <x-untitledui-message-text-square class="size-5" aria-hidden="true" />
                        {{ __('global.launch_modal.discussion_action') }}
                    </x-buttons.primary>
                @endcan
            @endif
        </div>
    </x-empty-state>
@endif
