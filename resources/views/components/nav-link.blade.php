@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'bg-green-100 text-green-800 group flex items-center px-3 py-2 text-sm font-medium font-sans rounded-md transition duration-150 ease-in-out'
                : 'text-skin-base hover:bg-skin-card group flex items-center px-3 py-2 text-sm font-medium font-sans rounded-md transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
