@props([
    'user',
])

<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="relative group overflow-hidden rounded-xl bg-white dark:bg-gray-800 px-4 py-5 ring-1 ring-gray-200/60 dark:ring-white/10 sm:p-6">
        <dt class="truncate text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/account.dashboard.stats.discussions') }}
        </dt>
        <dd class="mt-2 text-3xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white">
            {{ \Illuminate\Support\Number::format($user->articles_count + $user->discussions_count) }}
        </dd>
        <span class="absolute z-0 -bottom-2 right-0 text-primary-600/50 rotate-12 transform transition duration-200 ease-in-out group-hover:scale-105 group-hover:rotate-[10deg]">
            <x-untitledui-file-05 class="size-20" stroke-width="1.5" aria-hidden="true" />
        </span>
    </div>

    <div class="relative group overflow-hidden rounded-xl bg-white dark:bg-gray-800 px-4 py-5 ring-1 ring-gray-200/60 dark:ring-white/10 sm:p-6">
        <dt class="truncate text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/account.dashboard.stats.thread_reply') }}
        </dt>
        <dd class="mt-2 text-3xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white">
            {{ \Illuminate\Support\Number::format($user->replies_count) }}
        </dd>
        <span class="absolute z-0 -bottom-2 right-0 text-primary-600/50 rotate-12 transform transition duration-200 ease-in-out group-hover:scale-105 group-hover:rotate-[10deg]">
            <x-untitledui-message-chat-square class="size-20" stroke-width="1.5" aria-hidden="true" />
        </span>
    </div>

    <div class="relative group overflow-hidden rounded-xl bg-white dark:bg-gray-800 px-4 py-5 ring-1 ring-gray-200/60 dark:ring-white/10 sm:p-6">
        <dt class="truncate text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/account.dashboard.stats.thread_resolved') }}
        </dt>
        <dd class="mt-2 text-3xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white">
            {{ \Illuminate\Support\Number::format($user->solutions_count) }}
        </dd>
        <span class="absolute z-0 -bottom-2 right-0 text-primary-600/50 rotate-12 transform transition duration-200 ease-in-out group-hover:scale-105 group-hover:rotate-[10deg]">
            <x-untitledui-check-verified class="size-20" stroke-width="1.5" aria-hidden="true" />
        </span>
    </div>

    <div class="relative group overflow-hidden rounded-xl bg-white dark:bg-gray-800 px-4 py-5 ring-1 ring-gray-200/60 dark:ring-white/10 sm:p-6">
        <dt class="truncate text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/account.dashboard.stats.experience') }}
        </dt>
        <dd class="mt-2 text-3xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white">
            {{ $user->getPoints() }}
        </dd>
        <span class="absolute z-0 -bottom-2 right-0 text-primary-600/50 rotate-12 transform transition duration-200 ease-in-out group-hover:scale-105 group-hover:rotate-[10deg]">
            <x-untitledui-trophy-02 class="size-20" stroke-width="1.5" aria-hidden="true" />
        </span>
    </div>
</dl>
