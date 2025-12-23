@props([
    'icon',
    'title',
    'description',
])

<div {{ $attributes->twMerge(['class' => 'relative p-6'])  }}>
    <dt class="shrink-0">
        {{ $icon }}
    </dt>
    <dd class="mt-4">
        <span class="text-base/5 font-medium text-gray-900 dark:text-white">
            {{ $title }}
        </span>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    </dd>
</div>
