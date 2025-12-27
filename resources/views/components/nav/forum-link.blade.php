@props([
    'active' => false,
    'href' => '#',
    'icon',
])

@php
    $activeClasses = $active
        ? 'border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white'
        : 'text-gray-500 border-transparent hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-950/50 dark:hover:text-white';

    $iconClasses = $active
        ? 'size-5 text-primary-600 dark:text-primary-500'
        : 'size-5 text-gray-400 dark:text-gray-500';
@endphp

<x-link
    :$href
    {{ $attributes->class([
        'group relative flex ml-px items-center gap-2 py-2 px-4 border-y hover:border-line text-sm font-medium',
        $activeClasses
    ]) }}
>
    @if ($active)
        <span class="absolute left-0 inset-y-0 w-0.5 bg-primary-600 dark:bg-primary-500"></span>
    @endif

    @if ($icon instanceof \Illuminate\View\ComponentAttributeBag)
        {{ $icon }}
    @else
        @svg($icon, $iconClasses, ['stroke-width' => '1.5', 'aria-hidden' => true])
    @endif

    {{ $slot }}
</x-link>
