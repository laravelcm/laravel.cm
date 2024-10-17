<nav class="space-y-6">
    <x-buttons.primary :href="route('forum.new')" class="gap-2 justify-between">
        {{ __('pages/forum.new_thread') }}
        <x-untitledui-plus class="size-4" stroke-width="1.5" aria-hidden="true" />
    </x-buttons.primary>

    <div class="sm:hidden">
        <x-forms.select
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
        >
            <option value="">Filtrer par channel</option>
            @foreach ($channels as $channel)
                <option
                    value="{{ route('forum.channels', $channel) }}"
                    @if(request()->fullUrlIs(route('forum.channels', $channel))) selected @endif
                >
                    {{ $channel->name }}
                </option>
                @if ($channel->items->isNotEmpty())
                    @foreach ($channel->items as $item)
                        <option
                            value="{{ route('forum.channels', $item) }}"
                            @if(request()->fullUrlIs(route('forum.channels', $item))) selected @endif
                        >
                            {{ $item->name }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        </x-forms.select>
    </div>

    <div class="hidden sm:block">
        <ul class="space-y-3">
            @foreach ($channels as $channel)
                <li class="{{ $loop->last ?: 'pb-4' }} relative">
                    <div class="absolute left-1 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-100" aria-hidden="true"></div>
                    <div class="flex items-center space-x-3">
                        <div
                            class="size-2 shrink-0 rounded-full"
                            aria-hidden="true"
                            style="background-color: {{ $channel->color }}"
                        ></div>
                        <x-link
                            :href="route('forum.channels', $channel)"
                            @class([
                                'truncate font-medium',
                                 'text-primary-600 hover:text-primary-600-hover' => url()->route('forum.channels', $channel) === request()->fullUrl(),
                                 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' => url()->route('forum.channels', $channel) !== request()->fullUrl()
                            ])
                        >
                            {{ $channel->name }}
                        </x-link>
                    </div>

                    @if ($channel->items->isNotEmpty())
                        <ul class="ml-8 mt-3 space-y-2">
                            @foreach ($channel->items as $item)
                                <li>
                                    <x-link
                                        :href="route('forum.channels', $item)"
                                        @class([
                                            'truncate text-sm',
                                             'text-primary-600 hover:text-primary-600-hover' => url()->route('forum.channels', $item) === request()->fullUrl(),
                                             'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' => url()->route('forum.channels', $item) !== request()->fullUrl()
                                        ])
                                    >
                                        {{ $item->name }}
                                    </x-link>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
