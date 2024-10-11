@props([
    'tag',
])

<span class="inline-flex items-center gap-1.5 rounded-full border border-gray-300 px-2.5 py-1.5 text-sm font-medium leading-none text-gray-700 dark:bg-gray-800 dark:text-white dark:border-white/20">
    <svg class="brand-{{ $tag->slug() }} size-2" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name() }}
</span>
