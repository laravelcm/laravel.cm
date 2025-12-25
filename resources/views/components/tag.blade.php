@props([
    'tag',
])

<x-link
   :href="route('articles.tag', $tag)"
    {{ $attributes->twMerge(['class' => 'inline-flex items-center text-xs gap-x-1 rounded-md px-2 py-1 font-medium inset-ring inset-ring-gray-500/10 text-gray-700 bg-gray-100 hover:bg-gray-200/70 dark:inset-ring-gray-400/20 dark:bg-gray-400/10 dark:hover:bg-white/20 dark:text-gray-400']) }}
>
    <svg class="brand-{{ $tag->slug }} size-2" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name }}
</x-link>
