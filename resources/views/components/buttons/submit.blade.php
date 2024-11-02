@props([
    'title' => null,
])

<x-buttons.primary
    type="submit"
    {{ $attributes->twMerge(['class' => 'relative data-[loading]:pointer-events-none']) }}
>
    <span class="inline-flex items-center gap-2 [[data-loading]>&]:opacity-0 transition-opacity delay-100">
        {{ $title ?? $slot }}
    </span>
    <span class="[[data-loading]>&]:opacity-100 opacity-0 absolute inset-0 flex items-center justify-center">
        <x-loader class="bg-white" />
    </span>
</x-buttons.primary>
