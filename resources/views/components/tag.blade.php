@props([
    'tag',
])

<x-link
   :href="route('articles.tag', $tag)"
    {{ $attributes->twMerge(['class' => 'inline-flex items-center text-sm gap-1.5 rounded-md px-2 py-1 font-medium whitespace-nowrap text-gray-700 bg-gray-400/15 hover:bg-gray-200/50 dark:bg-gray-400/40 dark:hover:bg-gray-400/50 dark:text-gray-200']) }}
>
    <svg class="brand-{{ $tag->slug }} size-2" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name }}
</x-link>
