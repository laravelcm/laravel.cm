<div class="max-w-lg w-full lg:max-w-xs cursor-pointer group" @click="$dispatch('toggle-spotlight')">
    <label for="search" class="sr-only">Recherche</label>
    <div class="relative">
        <div class="w-full pr-12 pl-4 py-2 border border-skin-base rounded-md text-skin-base leading-5 bg-skin-body font-normal text-skin-muted text-sm group-hover:bg-skin-card-gray">
            {{ __('Rechercher un contenu...') }}
        </div>
        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-2 pointer-events-none">
            <kbd class="inline-flex items-center border border-skin-base rounded px-2 text-sm font-sans font-medium text-skin-muted">
                ⌘K
            </kbd>
        </div>
    </div>
</div>
