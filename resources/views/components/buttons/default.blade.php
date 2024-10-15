@props(['link' => null])

@if ($link)
    <x-link
        href="{{ $link }}"
        {{ $attributes->twMerge(['class' => 'inline-flex justify-center py-2 px-4 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900']) }}
    >
        {{ $slot }}
    </x-link>
@else
    <button
        {{ $attributes->twMerge(['class' => 'inline-flex justify-center py-2 px-4 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900']) }}
    >
        {{ $slot }}
    </button>
@endif
