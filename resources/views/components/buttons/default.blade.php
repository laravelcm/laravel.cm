@php
    $classes = 'inline-flex items-center justify-center py-2 px-4 bg-white ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-xs font-medium text-sm text-gray-700 hover:text-gray-900 hover:bg-white/50 dark:text-white dark:hover:text-white dark:bg-gray-800 dark:hover:bg-white/10 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 dark:focus:ring-offset-gray-900';
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
