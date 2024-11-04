<div>
    @can('unsubscribe', $thread)
        <x-buttons.default type="button" class="w-full relative gap-2" wire:click="unsubscribe" wire:loading.attr="disabled">
            <x-untitledui-bell-off class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
            <span>{{ __('pages/forum.unsubscribe_thread') }}</span>
            <span class="absolute pointer-events-none inset-y-0 right-0 flex items-center pr-2" wire:loading wire:target="unsubscribe">
                <x-loader class="text-white" aria-hidden="true" />
            </span>
        </x-buttons.default>
    @elsecan('subscribe', $thread)
        <x-buttons.default type="button" class="w-full relative gap-2" wire:click="subscribe" wire:loading.attr="disabled">
            <x-untitledui-bell-ringing class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
            <span>{{ __('pages/forum.subscribe_thread') }}</span>
            <span class="absolute pointer-events-none inset-y-0 right-0 flex items-center pr-2" wire:loading wire:target="subscribe">
                <x-loader class="text-white" aria-hidden="true" />
            </span>
        </x-buttons.default>
    @endcan
</div>
