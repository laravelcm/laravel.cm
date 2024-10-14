<div class="relative lg:grid lg:grid-cols-12 lg:gap-8">
    <div class="relative hidden lg:col-span-2 lg:block">
        <x-sticky-content class="divide-y divide-skin-base">
            <div class="pb-6">
                <span
                    class="inline-flex items-center rounded-md bg-skin-link px-2 py-1 font-sans text-sm font-medium text-gray-500 dark:text-gray-400"
                >
                    <svg class="mr-1.5 h-2 w-2 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    Toutes les catégories
                </span>

                <x-tags :tags="$tags" :selected-tag="$selectedTag" />
            </div>
            @auth
                <div class="space-y-3 py-6">
                    <h4 class="font-heading text-sm leading-5 text-gray-500 dark:text-gray-400">Vous avez un sujet passionnant ?</h4>
                    <x-button :href="route('discussions.new')">Nouvelle discussion</x-button>
                </div>
            @endauth
        </x-sticky-content>
    </div>
    <div x-data x-intersect="@this.call('loadMore')" class="relative lg:col-span-7">
        <div class="w-full">
            <nav class="relative z-0 flex divide-x divide-skin-base rounded-lg shadow" aria-label="Tabs">
                <button
                    type="button"
                    wire:click="sortBy('recent')"
                    aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
                    class="{{ $selectedSortBy === 'recent' ? 'text-gray-900' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900' }} group relative w-full min-w-0 flex-1 overflow-hidden rounded-l-lg bg-skin-card px-6 py-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Récent</span>
                    <span
                        aria-hidden="true"
                        class="{{ $selectedSortBy === 'recent' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                    ></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('popular')"
                    aria-current="{{ $selectedSortBy === 'popular' ? 'page' : 'false' }}"
                    class="{{ $selectedSortBy === 'popular' ? 'text-gray-900' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900' }} group relative w-full min-w-0 flex-1 overflow-hidden bg-skin-card px-6 py-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Populaire</span>
                    <span
                        aria-hidden="true"
                        class="{{ $selectedSortBy === 'popular' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                    ></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('active')"
                    aria-current="{{ $selectedSortBy === 'active' ? 'page' : 'false' }}"
                    class="{{ $selectedSortBy === 'active' ? 'text-gray-900' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900' }} group relative w-full min-w-0 flex-1 overflow-hidden rounded-r-lg bg-skin-card px-6 py-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Actif</span>
                    <span
                        aria-hidden="true"
                        class="{{ $selectedSortBy === 'active' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
                    ></span>
                </button>
            </nav>
        </div>
        <div class="relative z-20 mt-4 divide-y divide-skin-base">
            @foreach ($discussions as $discussion)
                <x-discussions.overview :discussion="$discussion" />
            @endforeach
        </div>

        @if ($discussions->hasMorePages())
            <div x-data x-intersect="@this.call('loadMore')" class="mt-5 flex justify-center">
                <p class="flex items-center">
                    <x-loader class="text-primary-600" />
                    Chargement...
                </p>
            </div>
        @endif
    </div>
    <div wire:ignore class="relative hidden lg:col-span-3 lg:block">
        @include('discussions._contributions')
    </div>
</div>
