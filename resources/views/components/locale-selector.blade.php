@props([
    'locale',
])

<div
    {{ $attributes->twMerge(['class' => 'inline-flex items-center justify-start rounded-lg bg-gray-100/50 p-1 h-10 ring-1 ring-gray-200 dark:ring-white/10 dark:bg-gray-800 sm:w-auto']) }}
>
    @foreach (config('lcm.supported_locales') as $supportedLocale)
        <button
            type="button"
            aria-disabled="false"
            wire:click="selectLocale('{{ $supportedLocale }}')"
            @if ($supportedLocale === $locale)
                aria-current="page"
            @endif
            @class([
                'group inline-flex items-center justify-center capitalize whitespace-nowrap rounded-md align-middle font-medium transition-all duration-300 ease-in-out min-w-[32px] text-xs h-8 px-3 w-auto overflow-hidden',
                'hover:bg-gray-200/30 text-gray-900 dark:text-gray-300 bg-transparent' => $supportedLocale !== $locale,
                'bg-white shadow text-gray-700 dark:bg-gray-900 dark:text-white' => $supportedLocale === $locale,
            ])
        >
            {{ $supportedLocale }}
        </button>
    @endforeach
</div>
