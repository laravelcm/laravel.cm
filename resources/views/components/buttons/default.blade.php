@php
    $classes = 'inline-flex justify-center py-2 px-4 bg-white border-0 ring-1 ring-gray-200 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900';
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
