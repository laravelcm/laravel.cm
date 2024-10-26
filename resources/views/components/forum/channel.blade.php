@props([
    'channel',
])

<span
    {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 rounded-full text-gray-900 border border-gray-200 px-2.5 py-1 text-sm font-medium leading-none transition duration-200 ease-in-out dark:text-white']) }}
>
    <svg
        class="size-2 transition-colors duration-200"
        fill="{{ $channel->parent_id ? $channel->parent->color : $channel->color }}"
        viewBox="0 0 8 8"
    >
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $channel->name }}
</span>
