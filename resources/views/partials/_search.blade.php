<div class="max-w-lg w-full lg:max-w-xs" x-data="{ results: false, threads: [], articles: [] }">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <x-heroicon-o-search class="h-5 w-5 text-skin-muted"/>
        </div>
        <input
            @click.away="results = false"
            id="search"
            type="search"
            name="search"
            class="block w-full pl-10 pr-3 py-2 border border-skin-input rounded-md text-skin-base leading-5 bg-skin-body font-normal placeholder-skin-input focus:outline-none focus:placeholder-skin-input-focus focus:ring-1 focus:ring-green-500 focus:border-green-500 sm:text-sm"
            placeholder="{{ __('Rechercher un contenu...') }}"
        >
    </div>
</div>
