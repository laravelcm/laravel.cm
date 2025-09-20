<div x-data="{
    open: false,
    toggle() {
        this.open = ! this.open;
    },
    selectChannel (channelId) {
        $wire.selectedChannel(channelId);
        this.toggle();
    },
    reset() {
        $wire.resetChannel();
        this.toggle();
    }
}">
    <div class="relative">
        <button
            type="button"
            class="relative inline-flex w-full cursor-default items-center gap-2 rounded-lg bg-white dark:bg-gray-800 py-2 pl-3 pr-10 text-left text-gray-900 dark:text-white ring-1 ring-inset ring-gray-200 dark:ring-white/10 focus:outline-none focus:ring-2 focus:ring-primary-600 sm:w-52 sm:text-sm sm:leading-6"
            aria-haspopup="listbox"
            aria-expanded="true"
            aria-labelledby="listbolabel"
            @click="toggle()"
        >
            <span class="truncate">
                {{ $this->currentChannel ? $this->currentChannel->name : __('pages/forum.channel_lists') }}
            </span>
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <x-untitledui-chevron-down class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
            </span>
        </button>

        <div
            x-show="open"
            x-transition:leave="transition duration-100 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click.away="open = false"
            class="absolute z-10 mt-1 w-60 rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black dark:ring-white/10 ring-opacity-5 focus:outline-none overflow-hidden sm:text-sm"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbolabel"
            aria-activedescendant="listbox-option"
            style="display: none;"
        >
            @isset ($slug)
                <div class="relative border-b border-gray-200 dark:border-white/20">
                    <button
                        type="button"
                        @click="reset()"
                        class="flex items-center w-full py-2 px-4 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                    >
                        {{ __('global.reset') }}
                    </button>
                </div>
            @endisset
            <div class="max-h-96 overflow-auto">
                @foreach ($this->channels as $channel)
                    <div class="relative">
                        <div class="sticky top-0 bg-gray-50/90 dark:bg-gray-900/80 text-xs z-50 px-5 py-1 text-gray-700 dark:text-gray-300 font-semibold backdrop-blur-sm ring-1 ring-gray-900/10 dark:ring-white/10">
                            <div class="flex items-center justify-between gap-4">
                                <span class="relative flex items-center gap-2">
                                    <div
                                        class="size-2 shrink-0 rounded-full"
                                        aria-hidden="true"
                                        style="background-color: {{ $channel->color }}"
                                    ></div>
                                    {{ $channel->name }}
                                </span>
                                <button
                                    type="button"
                                    @click="selectChannel({{ $channel->id }})"
                                    class="inline-flex items-center py-1 px-2 text-[10px] text-gray-700 font-medium rounded-md bg-gray-100 hover:bg-gray-200/50 ring-1 ring-inset ring-gray-200 dark:text-gray-300 dark:bg-white/10 dark:hover:bg-white/30 dark:ring-white/10"
                                >
                                    {{ __('pages/forum.view_channel') }}
                                </button>
                            </div>
                        </div>
                        @if ($channel->items->isNotEmpty())
                            <ul role="list" class="py-1">
                                @foreach ($channel->items as $item)
                                    <li
                                        class="relative flex items-center select-none px-2"
                                        id="listbox-option-{{ $loop->index }}"
                                        role="option"
                                    >
                                        @if ($slug === $item->slug)
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-2 pr-4 text-primary-600">
                                                <x-untitledui-check-circle class="size-4" aria-hidden="true" />
                                            </span>
                                        @endif
                                        <button
                                            @click="selectChannel({{ $item->id }})"
                                            type="button"
                                            @class([
                                               'flex items-center w-full py-2 pl-6 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300',
                                               'font-medium text-gray-900' => $slug === $item->slug,
                                            ])>
                                            {{ $item->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
