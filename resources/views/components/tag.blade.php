@props([
    'tag',
])

<x-link
   :href="route('articles.tag', $tag)"
    {{ $attributes->twMerge(['class' => 'inline-flex items-center text-sm gap-1.5 relative z-10 rounded-lg bg-gray-100 px-2 py-1 font-medium text-gray-600 hover:bg-gray-200/50 dark:bg-gray-800 dark:text-white']) }}
>
    <svg class="brand-{{ $tag->slug() }} size-2" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name }}
</x-link>
