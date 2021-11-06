<nav class="space-y-6">
    <x-button link="#">
        Nouveau Sujet
        <x-heroicon-o-plus-circle class="h-4 w-4 ml-2.5" />
    </x-button>
    <ul class="space-y-3">
        <li>
            <a href="{{ route('forum.index') }}" class="truncate text-skin-base hover:text-skin-primary">
                Tous les sujets
            </a>
        </li>
        @foreach($channels as $channel)
            <li class="relative {{ $loop->last ?: 'pb-4' }}">
                <div class="-ml-px absolute mt-0.5 top-4 left-1 w-0.5 h-full bg-skin-card" aria-hidden="true"></div>
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 w-2 h-2 rounded-full" aria-hidden="true" style="background-color: {{ $channel->color }}"></div>
                    <a href="{{ route('forum.channels', $channel) }}" class="truncate {{ url()->route('forum.channels', $channel) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-base hover:text-skin-inverted' }}">
                        {{ $channel->name }}
                    </a>
                </div>

                @if($channel->items->isNotEmpty())
                    <ul class="mt-3 ml-8 space-y-2">
                        @foreach($channel->items as $item)
                            <li>
                                <a href="{{ route('forum.channels', $item) }}" class="truncate {{ url()->route('forum.channels', $item) === request()->fullUrl() ? 'text-skin-primary hover:text-skin-primary-hover' : 'text-skin-base hover:text-skin-inverted font-normal' }}">
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
