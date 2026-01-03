@props([
    'user',
])

<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <livewire:components.monthly-stats
        :$user
        model-class="App\Models\Article"
        date-column="published_at"
        where-not-null-column="published_at"
        :title="__('pages/account.dashboard.stats.articles')"
        icon="phosphor-pencil-line-duotone"
    />

    <livewire:components.monthly-stats
        :$user
        model-class="App\Models\Discussion"
        :title="__('pages/account.dashboard.stats.discussions')"
        icon="phosphor-chats-duotone"
    />

    <livewire:components.monthly-stats
        :$user
        model-class="App\Models\Reply"
        :title="__('pages/account.dashboard.stats.thread_reply')"
        icon="phosphor-chat-centered-dots-duotone"
    />

    <flux:card class="flex flex-col p-1 bg-dotted dark:bg-gray-900 after:border-0">
        <div class="flex items-center justify-between p-2">
            <span class="text-sm text-gray-500 font-medium dark:text-gray-400">
                {{ __('pages/account.dashboard.stats.experience') }}
            </span>
            <x-phosphor-trophy-duotone class="size-5 text-gray-500 dark:text-gray-400" aria-hidden="true" />
        </div>
        <div class="mt-0.5 flex-1 bg-white rounded-xl p-3 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10 flex items-end justify-between gap-4">
            <div class="flex-1">
                <p class="text-2xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white lg:text-3xl">
                    {{ $user->getPoints() }}
                </p>
            </div>
        </div>
    </flux:card>
</dl>
