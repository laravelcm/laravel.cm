@php
    $classes = 'inline-flex items-center justify-center py-2 px-4 border-0 text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:ring-offset-gray-900';
@endphp

@if ($attributes->hasAny(['href', ':href']))
    <x-link :href="$href" {{ $attributes->twMerge(['class' => $classes]) }}>
        {{ $slot }}
    </x-link>
@else
    <button {{ $attributes->twMerge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
