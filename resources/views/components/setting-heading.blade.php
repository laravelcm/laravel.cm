@props([
    'title',
    'description',
])

<div>
    <h3 class="text-lg/6 font-medium text-gray-900 dark:text-white">
        {{ $title }}
    </h3>
    <p class="mt-2 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
        {{ $description }}
    </p>
</div>
