@props([
    'action',
    'title',
    'description' => null,
])

<div class="h-full overflow-hidden rounded-xl bg-white shadow-xl ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-white/10">
    <form wire:submit="{{ $action }}" class="flex h-full flex-col divide-y divide-gray-200/60 dark:divide-white/20">
        <header class="p-4 sm:py-6">
            <div class="flex items-start gap-3 justify-between">
                <h2 class="text-lg font-medium font-heading text-gray-900 dark:text-white lg:text-xl">
                    {{ $title }}
                </h2>
                <x-livewire-slide-over::close-icon />
            </div>

            @if ($description)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $description }}
                </p>
            @endif
        </header>
        <div class="h-0 flex-1 overflow-y-auto px-4 py-6">
            {{ $slot }}
        </div>
        <div class="flex shrink-0 justify-end gap-x-4 p-4">
            <flux:button wire:click="$dispatch('closePanel')" type="button" class="mt-3 sm:mt-0 sm:w-auto">
                {{ __('actions.cancel') }}
            </flux:button>
            <flux:button type="submit" variant="primary" class="border-0">
                {{ __('actions.save') }}
            </flux:button>
        </div>
    </form>
</div>
