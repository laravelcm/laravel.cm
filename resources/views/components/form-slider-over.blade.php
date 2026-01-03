@props([
    'action',
    'title',
    'description' => null,
])

<form wire:submit="{{ $action }}" class="flex h-full flex-col divide-y divide-gray-200/60 dark:divide-white/20">
    <div class="h-0 flex-1 overflow-y-auto py-6">
        <header class="px-4 sm:px-6">
            <div class="flex items-start gap-3 justify-between">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white lg:text-xl">
                    {{ $title }}
                </h2>
                <div class="flex h-7 items-center">
                    <button
                        type="button"
                        class="rounded-lg bg-white text-gray-400 hover:text-gray-500 focus:outline-hidden dark:bg-gray-900 dark:text-gray-500 dark:hover:text-gray-300"
                        wire:click="$dispatch('closePanel')"
                    >
                        <span class="sr-only">{{ __('global.close_navigation') }}</span>
                        <x-untitledui-x class="size-6" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
            @if ($description)
                <div class="mt-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $description }}
                    </p>
                </div>
            @endif
        </header>
        <div class="mt-8 flex-1 px-4 sm:px-6">
            {{ $slot }}
        </div>
    </div>
    <div class="flex shrink-0 justify-end space-x-4 p-4">
        <x-buttons.default wire:click="$dispatch('closePanel')" type="button" class="mt-3 sm:mt-0 sm:w-auto">
            {{ __('actions.cancel') }}
        </x-buttons.default>
        <x-buttons.submit
            wire.loading.attr="data-loading"
            :title="__('actions.save')"
        />
    </div>
</form>
