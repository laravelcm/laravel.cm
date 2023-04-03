<div class="relative lg:grid lg:grid-cols-12 lg:gap-8">
    <div class="hidden relative lg:block lg:col-span-2">
        <x-sticky-content class="divide-y divide-skin-base">
            <div class="pb-6">
                <span class="inline-flex items-center px-2 py-1 rounded-md text-sm font-medium bg-skin-link text-skin-base font-sans">
                    <svg class="mr-1.5 h-2 w-2 text-skin-base" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    {{ __('Toutes les catégories') }}
                </span>

                <x-tags :tags="$tags" :selected-tag="$selectedTag" />
            </div>
            @auth
                <div class="py-6 space-y-3">
                    <h4 class="text-sm leading-5 font-sans text-skin-base">{{ __('Vous avez un sujet passionnant ?') }}</h4>
                    <x-button :link="route('discussions.new')">{{ __('Nouvelle discussion') }}</x-button>
                </div>
            @endauth
        </x-sticky-content>
    </div>
    <div
        x-data
        x-intersect="@this.call('loadMore')"
        class="relative lg:col-span-7"
    >
        <div class="w-full">
            <nav class="relative z-0 rounded-lg shadow flex divide-x divide-skin-base" aria-label="Tabs">
                <button
                    type="button"
                    wire:click="sortBy('recent')"
                    aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'recent' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>{{ __('Récent') }}</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'recent' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('popular')"
                    aria-current="{{ $selectedSortBy === 'popular' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'popular' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>{{ __('Populaire') }}</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'popular' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('active')"
                    aria-current="{{ $selectedSortBy === 'active' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'active' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>{{ __('Actif') }}</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'active' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>
            </nav>
        </div>
        <div class="relative mt-4 divide-y divide-skin-base z-20">
            @foreach($discussions as $discussion)
                <x-discussions.overview :discussion="$discussion" />
            @endforeach
        </div>

        @if($discussions->hasMorePages())
            <div
                x-data
                x-intersect="@this.call('loadMore')"
                class="mt-5 flex justify-center"
            >
                <p class="flex items-center">
                    <x-loader class="text-skin-primary" />
                    {{ __('Chargement...') }}
                </p>
            </div>
        @endif
    </div>
    <div wire:ignore class="hidden relative lg:block lg:col-span-3">
        @include('discussions._contributions')
    </div>
</div>
