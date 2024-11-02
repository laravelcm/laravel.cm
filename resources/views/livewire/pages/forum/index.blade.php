<div>
    <x-slot:buttons>
        <x-buttons.primary
            type="button"
            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
            class="gap-2 w-full justify-center py-2.5"
        >
            {{ __('pages/forum.new_thread') }}
            <span class="absolute pointer-events-none right-0 pr-3">
                <x-untitledui-plus class="size-5" aria-hidden="true" />
            </span>
        </x-buttons.primary>
    </x-slot:buttons>

    <div class="flex items-center justify-between gap-6">
        <livewire:components.channels-selector />

        <x-filament::input.wrapper class="relative max-w-60 w-full">
            <span class="pointer-events-none absolute top-2.5 left-0 pl-2.5">
                <x-untitledui-search-md class="size-4 text-gray-400 dark:text-gray-500" aria-hidden="true" />
            </span>
            <x-filament::input
                type="search"
                id="thread-search"
                name="search"
                class="!pl-8"
                wire:model.live.debounce.550ms="search"
                aria-label="{{ __('global.search') }}"
                :placeholder="__('pages/forum.thread_search')"
            />
        </x-filament::input.wrapper>
    </div>

    <div class="mt-6 lg:mb-12">
        <div class="space-y-6">
            @foreach ($threads as $thread)
                <x-forum.thread :thread="$thread" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $threads->links() }}
        </div>
    </div>
</div>
