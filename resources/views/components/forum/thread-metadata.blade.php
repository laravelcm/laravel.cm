@props([
    'thread',
    'vertical' => false,
])

<div {{ $attributes->class([
    'flex items-center gap-2 text-sm',
    'flex-col' => $vertical
]) }}>
    <p @class([
        'inline-flex items-center gap-2',
        'flex-col justify-center' => $vertical
    ])>
        <x-untitledui-message-text-square-02 class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
        <span class="text-gray-500 proportional-nums font-mono dark:text-gray-400">{{ $thread->replies_count }}</span>
        <span class="sr-only">{{ __('global.answers') }}</span>
    </p>

    <p @class([
        'inline-flex items-center gap-1',
        'flex-col justify-center' => $vertical
    ])>
        <x-untitledui-eye class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
        <span class="text-gray-500 proportional-nums font-mono dark:text-gray-400">{{ $thread->views_count }}</span>
        <span class="sr-only">{{ __('global.views') }}</span>
    </p>
</div>
