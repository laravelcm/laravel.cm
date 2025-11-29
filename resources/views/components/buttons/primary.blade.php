@php
    $classes = 'inline-flex items-center justify-center py-2 px-4 text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 dark:bg-primary-400/10 dark:hover:bg-primary-800/20 dark:text-primary-400 dark:ring-primary-500/20 dark:focus:ring-offset-gray-900';
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
