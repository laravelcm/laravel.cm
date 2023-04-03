@props(['thread'])

<div class="mt-5 thread bg-skin-card shadow rounded-md p-3 sm:p-4">
    @canany([App\Policies\ThreadPolicy::UPDATE, App\Policies\ThreadPolicy::DELETE], $thread)
        <div class="flex items-center justify-end mb-4">
            <div class="shrink-0 self-center flex">
                <div x-data="{ open: false }" @keydown.escape.stop="open = false;" @click.away="open = false" class="relative inline-block text-left">
                    <div>
                        <button type="button"
                                class="-m-2 p-2 rounded-full flex items-center text-skin-muted hover:text-skin-base"
                                x-ref="button"
                                @click="open = !open"
                                aria-expanded="false"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open.toString()">
                            <span class="sr-only">{{ __('Afficher les options') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
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
                            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                                <a href="{{ route('forum.edit', $thread) }}" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                                    <svg class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    <span>{{ __('Éditer') }}</span>
                                </a>
                            @endcan
                            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                                <button type="button" onclick="Livewire.emit('openModal', 'modals.delete-thread', {{ json_encode([$thread->id]) }})" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                                    <x-heroicon-s-trash class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                                    <span>{{ __('Supprimer') }}</span>
                                </button>
                            @endcan
                            <a href="#" class="group text-skin-inverted-muted flex px-4 py-2 text-sm hover:text-skin-inverted" role="menuitem" tabindex="-1">
                                <x-heroicon-s-flag class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                                <span>{{ __('Signaler contenu') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcanany
    <div class="prose prose-base prose-green text-skin-base max-w-none">
        <x-markdown-content :content="$thread->body" />
    </div>
    <div class="mt-6">
        <livewire:reactions wire:key="$thread->id" :model="$thread" :with-place-holder="false" :with-background="false"/>
    </div>
</div>
