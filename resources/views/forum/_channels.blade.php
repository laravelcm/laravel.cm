<nav class="space-y-6">
    <x-button :link="route('forum.new')" class="flex w-full justify-between">
        Nouveau Sujet
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="ml-2.5 h-4 w-4"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </x-button>
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
    <ul class="hidden sm:block sm:space-y-3">
        <li>
            <a href="{{ route('forum.index') }}" class="truncate text-skin-base hover:text-skin-primary">
                Tous les sujets
            </a>
        </li>
        @foreach ($channels as $channel)
            <li class="{{ $loop->last ?: 'pb-4' }} relative">
                <div class="absolute left-1 top-4 -ml-px mt-0.5 h-full w-0.5 bg-skin-card" aria-hidden="true"></div>
                <div class="flex items-center space-x-3">
                    <div
                        class="h-2 w-2 shrink-0 rounded-full"
                        aria-hidden="true"
                        style="background-color: {{ $channel->color }}"
                    ></div>
                    <a
                        href="{{ route('forum.channels', $channel) }}"
                        class="{{ url()->route('forum.channels', $channel) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-inverted-muted hover:text-skin-inverted' }} truncate font-medium"
                    >
                        {{ $channel->name }}
                    </a>
                </div>

                @if ($channel->items->isNotEmpty())
                    <ul class="ml-8 mt-3 space-y-2">
                        @foreach ($channel->items as $item)
                            <li>
                                <a
                                    href="{{ route('forum.channels', $item) }}"
                                    class="{{ url()->route('forum.channels', $item) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-base hover:text-skin-inverted' }} truncate"
                                >
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
