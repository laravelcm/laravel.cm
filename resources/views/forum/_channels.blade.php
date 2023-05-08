<nav class="space-y-6">
    <x-button :link="route('forum.new')" class="w-full flex justify-between">
        {{ __('Nouveau Sujet') }}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 ml-2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </x-button>
    <div class="sm:hidden">
        <x-forms.select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">{{ __('Filtrer par channel') }}</option>
            @foreach($channels as $channel)
                <option value="{{ route('forum.channels', $channel) }}" @if(request()->fullUrlIs(route('forum.channels', $channel))) selected @endif>{{ $channel->name }}</option>
                @if($channel->items->isNotEmpty())
                    @foreach($channel->items as $item)
                        <option value="{{ route('forum.channels', $item) }}" @if(request()->fullUrlIs(route('forum.channels', $item))) selected @endif>{{ $item->name }}</option>
                    @endforeach
                @endif
            @endforeach
        </x-forms.select>
    </div>
    <ul class="hidden sm:block sm:space-y-3">
        <li>
            <a href="{{ route('forum.index') }}" class="truncate text-skin-base hover:text-skin-primary">
                {{ __('Tous les sujets') }}
            </a>
        </li>
        @foreach($channels as $channel)
            <li class="relative {{ $loop->last ?: 'pb-4' }}">
                <div class="-ml-px absolute mt-0.5 top-4 left-1 w-0.5 h-full bg-skin-card" aria-hidden="true"></div>
                <div class="flex items-center space-x-3">
                    <div class="shrink-0 w-2 h-2 rounded-full" aria-hidden="true" style="background-color: {{ $channel->color }}"></div>
                    <a href="{{ route('forum.channels', $channel) }}" class="truncate font-medium {{ url()->route('forum.channels', $channel) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-inverted-muted hover:text-skin-inverted' }}">
                        {{ $channel->name }}
                    </a>
                </div>

                @if($channel->items->isNotEmpty())
                    <ul class="mt-3 ml-8 space-y-2">
                        @foreach($channel->items as $item)
                            <li>
                                <a href="{{ route('forum.channels', $item) }}" class="truncate {{ url()->route('forum.channels', $item) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-base hover:text-skin-inverted' }}">
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
