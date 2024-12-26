@props([
    'icon',
    'title',
    'description',
])

<div class="relative">
    <dt class="shrink-0">
        {{ $icon }}
    </dt>
    <dd class="mt-4 text-sm text-gray-500 dark:text-gray-400">
        <span class="font-medium text-gray-900 dark:text-white">
            {{ $title }}
        </span>
        <p class="mt-1 text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    </dd>
</div>
