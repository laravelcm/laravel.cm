@props(['selectedSortBy', 'forMobile' => false])

@if(! $forMobile)
    <div class="pb-8 space-y-1">
        <button
            type="button"
            wire:click="sortBy('recent')"
            aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
            class="{{ $selectedSortBy === 'recent' ? 'bg-skin-link text-skin-inverted': 'text-skin-base' }} group flex w-full items-center px-3 py-2 text-sm font-medium rounded-md font-sans"
        >
            <svg class="text-skin-base shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path d="M15.596 15.696h-7.22M15.596 11.937h-7.22M11.131 8.177H8.376" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path clip-rule="evenodd" d="M3.61 12c0 6.937 2.098 9.25 8.391 9.25 6.294 0 8.391-2.313 8.391-9.25 0-6.937-2.097-9.25-8.391-9.25C5.708 2.75 3.61 5.063 3.61 12z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="truncate">Récent</span>
        </button>

        <button
            type="button"
            wire:click="sortBy('popular')"
            aria-current="{{ $selectedSortBy === 'popular' ? 'page' : 'false' }}"
            class="{{ $selectedSortBy === 'popular' ? 'bg-skin-link text-skin-inverted': 'text-skin-base' }} group flex w-full items-center px-3 py-2 text-sm font-medium rounded-md font-sans"
        >
            <svg class="text-skin-muted group-hover:text-skin-base shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path clip-rule="evenodd" d="M12 3C9.964 3 9.771 6.547 8.56 7.8c-1.213 1.253-4.982-.18-5.505 2.044-.523 2.225 2.867 2.98 3.285 4.89.42 1.909-1.65 4.59.12 5.926 1.77 1.334 3.674-1.685 5.54-1.685s3.77 3.019 5.54 1.685c1.77-1.335-.3-4.017.12-5.927.419-1.909 3.808-2.664 3.285-4.889-.522-2.224-4.292-.791-5.503-2.044C14.23 6.547 14.036 3 12 3z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="truncate">Populaire</span>
        </button>

        <button
            type="button"
            wire:click="sortBy('trending')"
            aria-current="{{ $selectedSortBy === 'trending' ? 'page' : 'false' }}"
            class="{{ $selectedSortBy === 'trending' ? 'bg-skin-link text-skin-inverted': 'text-skin-base' }} group flex w-full items-center px-3 py-2 text-sm font-medium rounded-md font-sans"
        >
            <svg class="text-skin-muted group-hover:text-skin-base shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path d="M6.98 4.601V17.22M2.9 8.7s2.169-4.1 4.078-4.1c1.908 0 4.078 4.1 4.078 4.1M16.906 19.428V6.81M20.985 15.329s-2.17 4.1-4.078 4.1c-1.908 0-4.078-4.1-4.078-4.1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="truncate">Tendance</span>
        </button>
    </div>
@else
    <div class="mt-10 max-w-lg mx-auto lg:hidden">
        <nav class="relative z-0 rounded-lg shadow flex divide-x divide-skin-base" aria-label="Tabs">
            <button
                type="button"
                wire:click="sortBy('recent')"
                aria-current="{{ $selectedSortBy === 'recent' ? 'page' : 'false' }}"
                class="w-full {{ $selectedSortBy === 'recent' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
            >
                <span>Récents</span>
                <span aria-hidden="true" class="{{ $selectedSortBy === 'recent' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
            </button>

            <button
                type="button"
                wire:click="sortBy('popular')"
                aria-current="{{ $selectedSortBy === 'popular' ? 'page' : 'false' }}"
                class="w-full {{ $selectedSortBy === 'popular' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
            >
                <span>Populaire</span>
                <span aria-hidden="true" class="{{ $selectedSortBy === 'popular' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
            </button>

            <button
                type="button"
                wire:click="sortBy('trending')"
                aria-current="{{ $selectedSortBy === 'trending' ? 'page' : 'false' }}"
                class="w-full {{ $selectedSortBy === 'trending' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
            >
                <span>Tendance</span>
                <span aria-hidden="true" class="{{ $selectedSortBy === 'trending' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
            </button>
        </nav>
    </div>
@endif
