<div>
    <x-slot:buttons>
        <div class="px-4">
            <flux:button
                type="button"
                onclick="{{ Auth::check() ? 'Livewire.dispatch(\'openPanel\', { component: \'components.slideovers.thread-form\' })' : 'Livewire.dispatch(\'redirectToLogin\') ' }}"
                class="border-0 w-full"
                variant="primary"
            >
                {{ __('pages/forum.new_thread') }}
            </flux:button>
        </div>
    </x-slot:buttons>

    <div class="p-4">
        <div>
            <h1 class="text-xl font-semibold font-heading text-gray-900 dark:text-white lg:text-2xl">
                {{ __('pages/channel.title') }}
            </h1>
            <x-forum.channels-grid :channels="$this->channels" />
        </div>
        <div class="mt-10">
            <h1 class="text-xl font-semibold font-heading text-gray-900 dark:text-white lg:text-2xl">
                {{ __('pages/channel.subtitle') }}
            </h1>
            <x-forum.channels-grid :channels="$this->childChannels" />
        </div>
    </div>
</div>
