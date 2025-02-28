@props([
    'title',
    'button',
    'url',
])

<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="font-heading text-lg font-bold leading-7 text-gray-900 sm:truncate sm:text-xl">
            {{ $title }}
        </h2>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <x-buttons.primary :href="$url">
            {{ $button }}
        </x-buttons.primary>
    </div>
</div>
