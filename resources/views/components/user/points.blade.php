@props([
    'author',
])

<span
    {{ $attributes->twMerge(['class' => 'inline-flex items-center rounded-lg bg-white dark:bg-gray-800 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-300']) }}
>
    {{ $author->getPoints() }} XP
</span>
