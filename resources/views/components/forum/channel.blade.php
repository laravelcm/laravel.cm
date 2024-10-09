@props([
    'channel',
])

<span
    class="inline-flex items-center rounded-full border border-skin-input px-2.5 py-1 font-sans text-sm font-medium leading-none text-gray-900"
>
    <svg
        class="mr-1.5 h-2 w-2"
        fill="{{ $channel->parent_id ? $channel->parent->color : $channel->color }}"
        viewBox="0 0 8 8"
    >
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $channel->name }}
</span>
