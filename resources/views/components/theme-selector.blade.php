@props([
    'theme',
])

<div
    {{ $attributes->twMerge(['class' => 'inline-flex items-center justify-start rounded-lg bg-gray-100/50 p-1 h-10 ring-1 ring-gray-200 dark:ring-white/10 dark:bg-gray-800 sm:w-auto']) }}
>
    @foreach(config('lcm.supported_themes') as $supportedThemes)
        <button
            type="button"
            aria-disabled="false"
            wire:click="changeTheme('{{ $supportedThemes }}')"
            @class([
                'group inline-flex items-center justify-center  whitespace-nowrap rounded-md transition-all duration-300 ease-in-out min-w-[32px]  h-8 px-3 w-auto overflow-hidden',
                'hover:bg-gray-200/30 text-gray-900 dark:text-gray-100 bg-transparent' => $supportedThemes !== $theme,
                'bg-white shadow text-gray-700 dark:bg-gray-700 ' => $supportedThemes === $theme,
            ])
        >
            @if($supportedThemes === 'dark') <x-icon.moon class="class-4" /> @endif
            @if($supportedThemes === 'light') <x-icon.sun class="class-4" /> @endif
        </button>
    @endforeach
</div>
