@props([
    'active' => false,
    'href' => '#',
    'icon',
])

@php
    $activeClasses = $active
        ? 'ring-1 ring-gray-200 bg-gray-100 dark:bg-gray-800 dark:ring-white/10'
        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white';
@endphp

<x-link
    :href="$href"
    {{ $attributes->class([
        'group flex items-center gap-2 py-2 px-3 rounded-lg text-sm font-medium transition duration-200 ease-in-out',
        $activeClasses
    ]) }}
>
    @if($icon instanceof \Illuminate\View\ComponentAttributeBag)
        {{ $icon }}
    @else
        @svg($icon, 'size-5 text-gray-400 dark:text-gray-500', ['stroke-width' => '1.5', 'aria-hidden' => true])
    @endif
    {{ $slot }}
</x-link>
