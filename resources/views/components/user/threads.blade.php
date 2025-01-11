@props([
    'user',
    'threads',
])

@if ($threads->isNotEmpty())
    <div class="space-y-4">
        @foreach ($threads as $thread)
            <x-forum.thread :thread="$thread" wire:key="{{ $thread->slug }}" />
        @endforeach
    </div>
@else
    <x-empty-state>
        <div class="relative">
            <div class="relative">
                <div class="absolute -inset-1 w-72 mx-auto bg-gradient-to-r from-flag-green to-flag-red rounded-lg blur opacity-25"></div>
                <div class="relative flex items-start w-72 mx-auto shadow z-20 bg-white gap-3 p-4 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                    <div class="size-10 bg-gray-50 border border-gray-200 ring-2 ring-offset-2 ring-offset-gray-50 ring-gray-200/50 dark:ring-offset-gray-900 dark:border-white/20 dark:ring-white/20 rounded-full dark:bg-gray-800"></div>
                    <div class="w-3/4 space-y-2">
                        <div class="h-2 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                        <div class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                    </div>
                </div>
            </div>
            <div class="absolute z-1 inset-x-0 -top-10 transform scale-90">
                <div class="relative flex items-start w-72 mx-auto shadow z-20 bg-white gap-3 p-4 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                    <div class="size-10 bg-gray-50 border border-gray-200 ring-2 ring-offset-2 ring-offset-gray-50 ring-gray-200/50 dark:ring-offset-gray-900 dark:border-white/20 dark:ring-white/20 rounded-full dark:bg-gray-800"></div>
                    <div class="w-3/4 space-y-2">
                        <div class="h-2 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                        <div class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 space-y-4">
            <p class="mt-8 text-base text-gray-500 dark:text-gray-400">
                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                {{ __('pages/account.activities.empty_threads') }}
            </p>

            @if ($user->isLoggedInUser())
                @can('create', \App\Models\Thread::class)
                    <x-buttons.primary type="button">
                        <x-untitledui-message-text-square class="size-5" aria-hidden="true" />
                        {{ __('global.launch_modal.discussion_action') }}
                    </x-buttons.primary>
                @endcan
            @endif
        </div>
    </x-empty-state>
@endif
