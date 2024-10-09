@props([
    'title',
    'content',
])

<div>
    <h3 class="font-heading font-bold text-xl leading-7 text-gray-900 sm:text-2xl">{{ $title }}</h3>
    <p class="mt-2 leading-6 text-gray-500 dark:text-gray-400 sm:max-w-3xl sm:text-base">{{ $content }}</p>
</div>
