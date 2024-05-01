<div class="group w-full max-w-lg cursor-pointer lg:max-w-xs" @click="$dispatch('toggle-spotlight')">
    <label for="search" class="sr-only">Recherche</label>
    <div class="relative">
        <div
            class="w-full rounded-md border border-skin-base bg-skin-body py-2 pl-4 pr-12 text-sm font-normal leading-5 text-skin-muted group-hover:bg-skin-card-gray"
        >
            Rechercher un contenu...
        </div>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex py-1.5 pr-2">
            <kbd
                class="inline-flex items-center rounded border border-skin-base px-2 font-sans text-sm font-medium text-skin-muted"
            >
                ⌘K
            </kbd>
        </div>
    </div>
</div>
