@props([
    'title',
])

<x-buttons.primary
    type="submit"
    {{ $attributes->twMerge(['class' => 'data-[loading]:pointer-events-none']) }}
>
    <span class="[[data-loading]>&]:opacity-0 transition-opacity">
        {{ $title }}
    </span>
    <span class="[[data-loading]>&]:opacity-100 opacity-0 absolute inset-0 flex items-center justify-center">
        <x-loader class="bg-white" />
    </span>
</x-buttons.primary>
