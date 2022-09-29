<div class="relative" x-data="{ showReactions: false }">
    @if($model->getReactionsSummary()->isEmpty())
        <button
            @click="showReactions = ! showReactions"
            class="flex items-center text-skin-base hover:underline text-sm leading-5 focus:outline-none focus:ring-0"
        >
            @if($withPlaceHolder) Soyez le premier à réagir @endif
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
            </svg>
        </button>
    @else
        <button
            @click="showReactions = ! showReactions"
            @class([
                'flex relative justify-between items-center cursor-pointer h-8',
                'py-2 px-3 rounded-md bg-skin-card hover:bg-skin-card-muted rounded-md shadow' => $withBackground
            ])
        >
            <div class="flex items-center justify-center space-x-2">
                @foreach($model->getReactionsSummary() as $reaction)
                    <img class="w-4 h-4" src="{{ asset("/images/reactions/{$reaction->name}.svg") }}" alt="{{ $reaction->name }} emoji">
                @endforeach
                <span class="ml-3 text-sm font-medium text-green-500">{{ $model->getReactionsSummary()->sum('count') }}</span>
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
        @class([
            'origin-top absolute mt-4 w-56 rounded-md shadow-lg z-30',
            'left-0' => $direction === 'right',
            'right-0' => $direction !== 'right',
        ])
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
