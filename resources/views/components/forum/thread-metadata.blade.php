@props([
    'thread',
])

<div {{ $attributes->twMerge(['class' => 'flex items-center gap-2']) }}>
    <p class="inline-flex items-center gap-1 text-sm">
        <x-untitledui-message-text-square-02 class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
        <span class="text-gray-500 dark:text-gray-400">{{ count($thread->replies) }}</span>
        <span class="sr-only">{{ __('global.answers') }}</span>
    </p>

    <p class="inline-flex items-center gap-1 text-sm">
        <x-untitledui-eye class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
        <span class="text-gray-500 dark:text-gray-400">{{ $thread->views_count }}</span>
        <span class="sr-only">{{ __('global.views') }}</span>
    </p>
</div>
