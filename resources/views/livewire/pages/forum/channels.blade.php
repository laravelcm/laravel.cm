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

    <div>
        <div>
            <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white lg:text-2xl">
                {{ __('Les plus gros channels') }}
            </h1>
            <x-forum.channels-grid :channels="$channels" />
        </div>
        <div class="mt-10">
            <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white lg:text-2xl">
                {{ __('Les autres channels') }}
            </h1>
            <x-forum.channels-grid :channels="$childChannels" />
        </div>
    </div>
</div>
