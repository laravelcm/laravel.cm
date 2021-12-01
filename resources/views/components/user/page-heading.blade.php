@props(['title', 'button', 'url'])

<div class="md:flex md:items-center md:justify-between">
    <div class="flex-1 min-w-0">
        <h2 class="text-lg font-bold leading-7 text-skin-inverted sm:text-xl sm:truncate font-sans">
            {{ $title }}
        </h2>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <x-button :link="$url" class="ml-3">
            {{ $button }}
        </x-button>
    </div>
</div>
