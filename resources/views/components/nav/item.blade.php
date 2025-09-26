@props([
    'title',
    'activeLinks' => [],
    'href' => '#',
])

@php
    $activeClasses = active(
        routes: $activeLinks,
        activeClass: 'text-primary-600 hover:text-primary-500',
        defaultClass: 'text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white'
   );
@endphp

<x-link
    :href="$href"
    {{ $attributes->class(['relative inline-flex items-center text-sm font-medium', $activeClasses]) }}
>
    {{ $title }}
</x-link>
