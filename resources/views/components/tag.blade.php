@props([
    'tag',
])

<span
    class="inline-flex items-center rounded-full border border-skin-input px-2.5 py-1.5 text-sm font-medium leading-none text-skin-inverted"
>
    <svg class="brand-{{ $tag->slug() }} mr-1.5 h-2 w-2" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name() }}
</span>
