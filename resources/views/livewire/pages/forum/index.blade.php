<div>
    <x-slot:buttons>
        <x-buttons.primary
            type="button"
            onclick="{{ Auth::check() ? 'Livewire.dispatch(\'openPanel\', { component: \'components.slideovers.thread-form\' })' : 'Livewire.dispatch(\'redirectToLogin\') ' }}"
            class="gap-2 w-full justify-center py-2.5"
        >
            {{ __('pages/forum.new_thread') }}
            <span class="absolute pointer-events-none right-0 pr-3">
                <x-untitledui-plus class="size-5" aria-hidden="true" />
            </span>
        </x-buttons.primary>
    </x-slot:buttons>

    <div class="flex flex-col gap-6 lg:flex-row lg:items-center">
        <div class="flex items-center gap-4">
            <livewire:components.channels-selector :slug="$channel" />
        </div>

        <div class="flex items-center gap-x-4 lg:flex-1 lg:gap-x-6">
            <div class="flex-1 flex items-center gap-2">
                <x-locale-selector :$locale />

                <span wire:loading>
                    <x-loader class="text-flag-green" />
                </span>
            </div>

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
    </div>

    <div class="mt-6 lg:mb-12">
        <div class="space-y-4">
            @foreach ($threads as $thread)
                <x-forum.thread :thread="$thread" wire:key="{{ $thread->slug }}" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $threads->links() }}
        </div>
    </div>
</div>
