<div>
    @can('unsubscribe', $thread)
        <flux:button
            class="w-full"
            wire:click="unsubscribe"
        >
            {{--<x-untitledui-bell-off class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />--}}
            {{ __('pages/forum.unsubscribe_thread') }}
        </flux:button>
    @elsecan('subscribe', $thread)
        <flux:button
            class="w-full"
            wire:click="subscribe"
        >
            {{--<x-untitledui-bell-ringing class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />--}}
            {{ __('pages/forum.subscribe_thread') }}
        </flux:button>
    @endcan
</div>
