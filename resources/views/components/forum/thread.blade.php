@props(['thread'])

<div class="mt-5 thread bg-skin-card shadow rounded-md p-3 sm:p-4">
    <div class="flex items-center justify-end">
        <div class="flex-shrink-0 self-center flex">
            <div x-data="{ open: false }"  @keydown.escape.stop="open = false;" @click.away="open = false" class="relative inline-block text-left">
                <div>
                    <button type="button"
                            class="-m-2 p-2 rounded-full flex items-center text-skin-muted hover:text-skin-base"
                            x-ref="button"
                            @click="open = !open"
                            aria-expanded="false"
                            aria-haspopup="true"
                            x-bind:aria-expanded="open.toString()">
                        <span class="sr-only">Afficher les options</span>
                        <x-heroicon-s-dots-vertical class="h-5 w-5" />
                    </button>
                </div>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-skin-card ring-1 ring-black ring-opacity-5 focus:outline-none"
                     x-ref="menu-items"
                     role="menu"
                     aria-orientation="vertical"
                     aria-labelledby="options-menu-{{ $thread->id }}-button"
                     tabindex="-1"
                     @keydown.tab="open = false"
                     @keydown.enter.prevent="open = false;"
                     @keyup.space.prevent="open = false;"
                     style="display: none;">
                    <div class="py-1" role="none">
                        <a href="#" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                            <x-heroicon-s-pencil class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                            <span>Éditer</span>
                        </a>
                        <a href="#" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                            <x-heroicon-s-trash class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                            <span>Supprimer</span>
                        </a>
                        <a href="#" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                            <x-heroicon-s-flag class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                            <span>Signaler contenu</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="mt-4 prose prose-base prose-green text-skin-base max-w-none">
        <x-markdown-content :content="$thread->body" />
    </div>
</div>