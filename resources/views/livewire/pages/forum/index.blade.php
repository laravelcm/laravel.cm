<div>
    <x-slot:buttons>
        <p class="px-4">
            <flux:button
                type="button"
                onclick="{{ Auth::check() ? 'Livewire.dispatch(\'openPanel\', { component: \'components.slideovers.thread-form\' })' : 'Livewire.dispatch(\'redirectToLogin\') ' }}"
                class="border-0 w-full"
                variant="primary"
            >
                {{ __('pages/forum.new_thread') }}
            </flux:button>
        </p>
    </x-slot:buttons>

    <div class="p-4 border-b border-line bg-white z-20 mr-px flex items-center gap-x-4 sticky top-16 backdrop-blur-lg dark:bg-gray-950/80">
        <livewire:components.channels-selector :slug="$channel" />

        <div class="flex items-center gap-x-4 lg:flex-1">
            <div class="flex-1 flex items-center gap-2">
                <x-locale-selector :$locale />

                <span wire:loading>
                    <x-loader class="text-flag-green" />
                </span>
            </div>

            <flux:input
                :placeholder="__('pages/forum.thread_search')"
                icon="magnifying-glass"
                class="max-w-60 w-full"
                wire:model.live.debounce.550ms="search"
                clearable
            />
        </div>
    </div>

    <div class="pt-4 bg-dotted after:border-0 px-4">
        <div class="space-y-4">
            @foreach ($threads as $thread)
                <x-forum.thread :$thread wire:key="{{ $thread->slug }}" />
            @endforeach
        </div>

        <div class="py-10">
            {{ $threads->links() }}
        </div>
    </div>
</div>
