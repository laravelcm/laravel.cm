@props([
    'thread',
])

<div class="thread mt-5 rounded-md bg-skin-card p-3 shadow sm:p-4">
    @canany([App\Policies\ThreadPolicy::UPDATE, App\Policies\ThreadPolicy::DELETE], $thread)
        <div class="mb-4 flex items-center justify-end">
            <div class="flex shrink-0 self-center">
                <div
                    x-data="{ open: false }"
                    @keydown.escape.stop="open = false;"
                    @click.away="open = false"
                    class="relative inline-block text-left"
                >
                    <div>
                        <button
                            type="button"
                            class="-m-2 flex items-center rounded-full p-2 text-skin-muted hover:text-skin-base"
                            x-ref="button"
                            @click="open = !open"
                            aria-expanded="false"
                            aria-haspopup="true"
                            x-bind:aria-expanded="open.toString()"
                        >
                            <span class="sr-only">Afficher les options</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                                />
                            </svg>
                        </button>
                    </div>

                    <div
                        x-show="open"
                        x-transition:enter="transition duration-100 ease-out"
                        x-transition:enter-start="scale-95 transform opacity-0"
                        x-transition:enter-end="scale-100 transform opacity-100"
                        x-transition:leave="transition duration-75 ease-in"
                        x-transition:leave-start="scale-100 transform opacity-100"
                        x-transition:leave-end="scale-95 transform opacity-0"
                        class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-skin-card shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        x-ref="menu-items"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="options-menu-{{ $thread->id }}-button"
                        tabindex="-1"
                        @keydown.tab="open = false"
                        @keydown.enter.prevent="open = false;"
                        @keyup.space.prevent="open = false;"
                        style="display: none"
                    >
                        <div class="py-1" role="none">
                            @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                                <a
                                    href="{{ route('forum.edit', $thread) }}"
                                    class="group flex px-4 py-2 text-sm text-skin-inverted-muted hover:text-skin-inverted"
                                    role="menuitem"
                                    tabindex="-1"
                                >
                                    <svg
                                        class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                                        />
                                    </svg>
                                    <span>Éditer</span>
                                </a>
                            @endcan

                            @can(App\Policies\ThreadPolicy::DELETE, $thread)
                                <button
                                    type="button"
                                    onclick="Livewire.dispatch('openModal', {component: 'modals.delete-thread', arguments: {{ json_encode([$thread->id]) }} })"
                                    class="group flex px-4 py-2 text-sm text-skin-inverted-muted hover:text-skin-inverted"
                                    role="menuitem"
                                    tabindex="-1"
                                >
                                    <x-untitledui-trash-03
                                        class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base"
                                    />
                                    <span>Supprimer</span>
                                </button>
                            @endcan

                            <a
                                href="#"
                                class="group flex px-4 py-2 text-sm text-skin-inverted-muted hover:text-skin-inverted"
                                role="menuitem"
                                tabindex="-1"
                            >
                                <x-heroicon-s-flag class="mr-3 h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                                <span>Signaler contenu</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcanany

    <div class="prose prose-base prose-green max-w-none text-skin-base">
        <x-markdown-content :content="$thread->body" />
    </div>
    <div class="mt-6">
        <livewire:reactions
            wire:key="$thread->id"
            :model="$thread"
            :with-place-holder="false"
            :with-background="false"
        />
    </div>
</div>
