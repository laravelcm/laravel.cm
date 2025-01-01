@props([
    'user',
    'position',
])

@php
    $icon = match ($position) {
        1 => 'icon.trophies.first',
        2 => 'icon.trophies.second',
        3 => 'icon.trophies.third',
        default => 'phosphor-trophy-duotone',
    };

    $ranking = match ($position) {
        1 => __('global.first_place'),
        2 => __('global.second_place'),
        3 => __('global.third_place'),
        default => 'N/A',
    };

    $color = match ($position) {
        1 => 'success',
        2 => 'warning',
        3 => 'danger',
        default => 'gray',
    };
@endphp

<div class="bg-white divide-y divide-gray-200 rounded-lg ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10 dark:divide-white/10">
    <div class="flex gap-4 p-4">
        <div class="relative flex-1 flex items-center gap-2">
            <x-filament::badge :color="$color" class="absolute -top-7 !rounded-full">
                {{ $ranking }}
            </x-filament::badge>
            <x-user.avatar :user="$user" class="size-7" />
            <div class="text-sm truncate">
                <h5 class="font-medium text-gray-900 truncate dark:text-white">
                    {{ $user->name }}
                </h5>
                <span class="text-gray-500 dark:text-gray-400">
                    {{ '@' . $user->username }}
                </span>
            </div>
        </div>
        <div>
            <x-dynamic-component :component="$icon" class="size-10" aria-hidden="true" />
        </div>
    </div>
    <div class="flex divide-x divide-gray-200 dark:divide-white/10">
        <div class="flex flex-col px-4 py-2.5">
            <span class="text-xs/4 text-gray-400 capitalize dark:text-gray-500">
                {{ __('global.experience') }}
            </span>
            <span class="font-medium text-sm text-gray-700 dark:text-gray-300">
                {{ $user->getPoints() }}
            </span>
        </div>
        <div class="flex flex-col px-4 py-2.5">
            <span class="text-xs/4 text-gray-400 capitalize dark:text-gray-500">
                {{ __('global.answers') }}
            </span>
            <span class="font-medium text-sm text-gray-700 dark:text-gray-300">
                {{ $user->solutions_count }}
            </span>
        </div>
        @if($position === 1)
            <div class="flex flex-col px-4 py-2.5">
                <span class="text-xs/4 text-gray-400 capitalize dark:text-gray-500">
                    {{ __('global.last_active') }}
                </span>

                <span class="font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ $user->last_active_at?->diffForHumans() }}
                </span>
            </div>
        @else
            <div class="flex flex-col px-4 py-2.5 lg:hidden">
                <span class="text-xs/4 text-gray-400 capitalize dark:text-gray-500">
                    {{ __('global.last_active') }}
                </span>

                <span class="font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ $user->last_active_at?->diffForHumans() }}
                </span>
            </div>
        @endif
    </div>
</div>
