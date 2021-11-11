<div>
    <div class="lg:grid lg:grid-cols-3 lg:gap-10">
        <div class="hidden lg:flex items-center">
            <h3 class="text-skin-inverted text-xl">
                {{ number_format($threads->total()) }} Sujets
            </h3>
        </div>
        <div class="lg:col-span-2">
            <nav class="relative z-0 rounded-lg shadow flex divide-x divide-skin-base" aria-label="Tabs">
                <button
                    type="button"
                    wire:click="sortBy('recent')"
                    aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'recent' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Récents</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'recent' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('resolved')"
                    aria-current="{{ $selectedSortBy === 'resolved' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'resolved' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Résolus</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'resolved' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>

                <button
                    type="button"
                    wire:click="sortBy('unresolved')"
                    aria-current="{{ $selectedSortBy === 'unresolved' ? 'page' : 'false' }}"
                    class="w-full {{ $selectedSortBy === 'unresolved' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card py-4 px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
                >
                    <span>Non résolus</span>
                    <span aria-hidden="true" class="{{ $selectedSortBy === 'unresolved' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
                </button>
            </nav>
        </div>
    </div>
    <div class="my-10 lg:mb-32 space-y-6 sm:space-y-5">
        @foreach ($threads as $thread)
            <x-forum.thread-overview :thread="$thread" />
        @endforeach

        <div class="mt-10">
            {{ $threads->links() }}
        </div>
    </div>
</div>
