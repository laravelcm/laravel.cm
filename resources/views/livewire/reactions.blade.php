<div class="relative" x-data="{ showReactions: false }">
    @if ($model->getReactionsSummary()->isEmpty())
        <button
            @click="showReactions = ! showReactions"
            class="flex items-center text-sm leading-5 text-skin-base hover:underline focus:outline-none focus:ring-0"
        >
            @if ($withPlaceHolder)
                Soyez le premier à réagir
            @endif

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="ml-1.5 h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
                />
            </svg>
        </button>
    @else
        <button
            @click="showReactions = ! showReactions"
            @class([
                'relative flex h-8 cursor-pointer items-center justify-between',
                'rounded-md rounded-md bg-skin-card px-3 py-2 shadow hover:bg-skin-card-muted' => $withBackground,
            ])
        >
            <div class="flex items-center justify-center space-x-2">
                @foreach ($model->getReactionsSummary() as $reaction)
                    <img
                        class="h-4 w-4"
                        src="{{ asset("/images/reactions/{$reaction->name}.svg") }}"
                        alt="{{ $reaction->name }} emoji"
                    />
                @endforeach

                <span class="ml-3 text-sm font-medium text-green-500">
                    {{ $model->getReactionsSummary()->sum('count') }}
                </span>
            </div>
        </button>
    @endif

    <div
        @click.away="showReactions = false;"
        x-show="showReactions"
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 transform opacity-0"
        x-transition:enter-end="scale-100 transform opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 transform opacity-100"
        x-transition:leave-end="scale-95 transform opacity-0"
        @class([
            'absolute z-30 mt-4 w-56 origin-top rounded-md shadow-lg',
            'left-0' => $direction === 'right',
            'right-0' => $direction !== 'right',
        ])
        style="display: none"
    >
        <div class="rounded-md bg-skin-card p-3 pt-4 shadow-lg">
            <h5 class="ml-1 text-xs font-medium text-skin-base">Sélectionnez Une:</h5>
            <div class="reactions no-load mt-2 grid grid-cols-4 gap-2">
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('clap')"
                >
                    <img src="{{ asset('/images/reactions/clap.svg') }}" class="h-5 w-5" alt="clap emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('fire')"
                >
                    <img src="{{ asset('/images/reactions/fire.svg') }}" class="h-5 w-5" alt="fire emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('handshake')"
                >
                    <img src="{{ asset('/images/reactions/handshake.svg') }}" class="h-5 w-5" alt="handshake emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('joy')"
                >
                    <img src="{{ asset('/images/reactions/joy.svg') }}" class="h-5 w-5" alt="joy emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('love')"
                >
                    <img src="{{ asset('/images/reactions/love.svg') }}" class="h-5 w-5" alt="love emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('money')"
                >
                    <img src="{{ asset('/images/reactions/money.svg') }}" class="h-5 w-5" alt="money emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('party')"
                >
                    <img src="{{ asset('/images/reactions/party.svg') }}" class="h-5 w-5" alt="party emoji" />
                </button>
                <button
                    type="button"
                    class="col-span-1 flex h-8 w-8 cursor-pointer items-center justify-center rounded-md hover:bg-skin-card-muted focus:outline-none"
                    wire:click="userReacted('pray')"
                >
                    <img src="{{ asset('/images/reactions/pray.svg') }}" class="h-5 w-5" alt="pray" />
                </button>
            </div>
        </div>
    </div>
</div>
