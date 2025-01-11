<div @class([
    'relative inline-flex items-center',
    'justify-center' => $direction === 'vertical',
]) x-data="{ showReactions: false }">
    @php
        $buttonClasses = 'inline-flex items-center justify-center size-6 rounded-full focus:outline-none';
    @endphp

    @if ($model->reactions->isEmpty())
        <button
            @click="showReactions = ! showReactions"
            class="group inline-flex items-center gap-2 text-sm leading-5 text-gray-500 dark:text-gray-400 hover:underline focus:outline-none"
        >
            @if ($withPlaceHolder)
                {{ __('global.first_to_react') }}
            @endif

            <x-untitledui-heart
                class="size-5 text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300"
                stroke-width="1.5"
                aria-hidden="true"
            />
        </button>
    @else
        <button
            @click="showReactions = ! showReactions"
            @class([
                'group relative flex items-center h-8 cursor-pointer items-center justify-between',
                'rounded-lg bg-white px-3 py-2 shadow hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700' => $withBackground,
            ])
        >
            @if($direction === 'vertical')
                <div class="flex flex-col items-center justify-center gap-y-1">
                    <x-untitledui-heart
                        class="size-5 text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300"
                        stroke-width="1.5"
                        aria-hidden="true"
                    />
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $model->reactions->count() }}
                    </span>
                </div>
            @else
                <div class="flex items-center justify-center space-x-2">
                    @foreach ($model->reactions as $reaction)
                        <img
                            loading="lazy"
                            class="size-4"
                            src="{{ asset("/images/reactions/{$reaction->name}.svg") }}"
                            alt="{{ $reaction->name }} emoji"
                        />
                    @endforeach

                    <span class="ml-3 text-sm font-medium text-green-500">
                        {{ $model->reactions->count() }}
                    </span>
                </div>
            @endif
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
        class="absolute z-30 left-6 w-auto origin-top-left"
        style="display: none"
    >
        <div class="rounded-full bg-white ring-1 ring-inset ring-gray-100 px-3 py-1.5 dark:bg-gray-800 dark:ring-white/10">
            <div class="reactions flex items-center gap-4">
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('clap')">
                    <img loading="lazy" src="{{ asset('/images/reactions/clap.svg') }}" class="size-5" alt="clap emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('fire')">
                    <img loading="lazy"  src="{{ asset('/images/reactions/fire.svg') }}" class="size-5" alt="fire emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('handshake')">
                    <img loading="lazy" src="{{ asset('/images/reactions/handshake.svg') }}" class="size-5" alt="handshake emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('joy')">
                    <img loading="lazy" src="{{ asset('/images/reactions/joy.svg') }}" class="size-5" alt="joy emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('love')">
                    <img loading="lazy" src="{{ asset('/images/reactions/love.svg') }}" class="size-5" alt="love emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('money')">
                    <img loading="lazy" src="{{ asset('/images/reactions/money.svg') }}" class="size-5" alt="money emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('party')">
                    <img loading="lazy" src="{{ asset('/images/reactions/party.svg') }}" class="size-5" alt="party emoji" />
                </button>
                <button type="button" class="{{ $buttonClasses }}" wire:click="userReacted('pray')">
                    <img loading="lazy" src="{{ asset('/images/reactions/pray.svg') }}" class="size-5" alt="pray" />
                </button>
            </div>
        </div>
    </div>
</div>
