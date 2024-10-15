@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'group flex items-center rounded-md bg-green-100 px-3 py-2 font-sans text-sm font-medium text-green-800 transition duration-150 ease-in-out'
            : 'group flex items-center rounded-md px-3 py-2 font-sans text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:bg-skin-card';
@endphp

<a {{ $attributes->twMerge(['class' => $classes]) }}>
    {{ $slot }}
</a>
