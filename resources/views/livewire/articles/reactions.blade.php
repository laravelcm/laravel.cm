<div class="pt-6 relative" x-data="{ showReactions: false }">
    @if($article->getReactionsSummary()->isEmpty())
        <button
            @click="showReactions = ! showReactions"
            class="flex items-center text-skin-base hover:underline text-sm leading-5 focus:outline-none focus:ring-0"
        >
            Soyez le premier à réagir
            <x-heroicon-o-emoji-happy class="h-5 w-5 ml-1.5" />
        </button>
    @else
        <button
            @click="showReactions = ! showReactions"
            class="rounded-md flex relative justify-between items-center py-2 px-3 cursor-pointer h-8 bg-skin-card hover:bg-skin-card-muted rounded-md shadow-md"
        >
            <div class="flex items-center justify-center space-x-2">
                @foreach($article->getReactionsSummary() as $reaction)
                    <img class="w-4 h-4" src="{{ asset("/images/reactions/{$reaction->name}.svg") }}" alt="{{ $reaction->name }} emoji">
                @endforeach
                <span class="ml-3 text-sm font-medium text-green-500">{{ $article->getReactionsSummary()->sum('count') }}</span>
            </div>
        </button>
    @endif

    <div
        @click.away="showReactions = false;"
        x-show="showReactions"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top absolute left-0 mt-4 w-56 rounded-md shadow-lg"
        style="display: none;"
    >
        <div class="p-3 pt-4 bg-skin-card rounded-md shadow-lg">
            <h5 class="ml-1 text-xs font-medium text-skin-base">Sélectionnez Une: </h5>
            <div class="mt-2 grid grid-cols-4 gap-2 reactions no-load">
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('clap')">
                    <img src="{{ asset('/images/reactions/clap.svg') }}" class="w-5 h-5" alt="clap emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('fire')">
                    <img src="{{ asset('/images/reactions/fire.svg') }}" class="w-5 h-5" alt="fire emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('handshake')">
                    <img src="{{ asset('/images/reactions/handshake.svg') }}" class="w-5 h-5" alt="handshake emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('joy')">
                    <img src="{{ asset('/images/reactions/joy.svg') }}" class="w-5 h-5" alt="joy emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('love')">
                    <img src="{{ asset('/images/reactions/love.svg') }}" class="w-5 h-5" alt="love emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('money')">
                    <img src="{{ asset('/images/reactions/money.svg') }}" class="w-5 h-5" alt="money emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('party')">
                    <img src="{{ asset('/images/reactions/party.svg') }}" class="w-5 h-5" alt="party emoji">
                </button>
                <button type="button" class="flex col-span-1 justify-center items-center rounded-md cursor-pointer h-8 w-8 hover:bg-skin-card-muted focus:outline-none" wire:click="userReacted('pray')">
                    <img src="{{ asset('/images/reactions/pray.svg') }}" class="w-5 h-5" alt="pray">
                </button>
            </div>
        </div>
    </div>
</div>
