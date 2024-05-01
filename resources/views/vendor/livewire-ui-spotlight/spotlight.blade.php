<div>
    @isset($jsPath)
        <script>
            {!! file_get_contents($jsPath) !!}
        </script>
    @endisset

    @isset($cssPath)
        <style>
            {!! file_get_contents($cssPath) !!}
        </style>
    @endisset

    <div
        x-data="LivewireUISpotlight({
                    componentId: '{{ $this->id }}',
                    placeholder: '{{ trans("livewire-ui-spotlight::spotlight.placeholder") }}',
                    commands: {{ $commands }},
                })"
        x-init="init()"
        x-show="isOpen"
        x-cloak
        @foreach (config("livewire-ui-spotlight.shortcuts") as $key)
            @keydown.window.prevent.cmd.
            {{ $key }}="toggleOpen()"
            @keydown.window.prevent.ctrl.{{ $key }}="toggleOpen()"
        @endforeach
        @keydown.window.escape="isOpen = false"
        @toggle-spotlight.window="toggleOpen()"
        class="fixed inset-0 z-50 flex items-start justify-center px-4 pt-16 sm:pt-24"
    >
        <div
            x-show="isOpen"
            x-transition:enter="duration-200 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="duration-150 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 backdrop-blur-sm backdrop-filter transition-opacity"
        >
            <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
        </div>
        <div
            x-show="isOpen && filteredItems().length <= 0"
            x-transition:enter="delay-200 duration-300 ease-out"
            x-transition:enter-start="-translate-y-12 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="duration-150 ease-in"
            x-transition:leave-start="translate-y-0 opacity-50"
            x-transition:leave-end="scale-95 opacity-0"
            class="fixed flex h-auto w-full transform items-center justify-center px-4 pt-16 text-gray-300 transition-all sm:px-0 sm:pt-24"
        >
            <template x-if="
                inputPlaceholder ==
                    '{{ trans("livewire-ui-spotlight::spotlight.placeholder") }}'
            ">
                <div class="w-full max-w-lg">
                    <div class="overflow-hidden rounded-lg bg-gray-100 bg-opacity-20 shadow-xl">
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez</div>
                            <div class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium uppercase text-gray-100">
                                Article
                            </div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher dans les articles</div>
                        </div>
                        <div class="h-0 w-full border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez</div>
                            <div class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium uppercase text-gray-100">
                                Discussion
                            </div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher dans les discussions</div>
                        </div>
                        <div class="h-0 w-full border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez</div>
                            <div class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium uppercase text-gray-100">
                                Sujet
                            </div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher un sujet dans le forum</div>
                        </div>
                        <div class="h-0 w-full border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez</div>
                            <div class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-medium uppercase text-gray-100">
                                User
                            </div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher un utilisateur spécifique</div>
                        </div>
                    </div>
                    <div class="mt-5 px-2 text-center text-xs text-gray-200 opacity-50">
                        ou, tapez une section pour accéder rapidement à cette page.
                    </div>
                </div>
            </template>
            <template x-if="
                inputPlaceholder !=
                    '{{ trans("livewire-ui-spotlight::spotlight.placeholder") }}'
            ">
                <div class="w-full max-w-lg rounded-lg bg-gray-100 bg-opacity-10 p-5 shadow-xl">
                    <span>Suivant,</span>
                    <span x-text="inputPlaceholder" class="lowercase"></span>
                </div>
            </template>
        </div>

        <div
            @click.outside="isOpen = false"
            x-show="isOpen"
            x-transition:enter="duration-200 ease-out"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="duration-150 ease-in"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="relative w-full max-w-lg transform overflow-hidden rounded-lg bg-gray-900 shadow-xl transition-all"
        >
            <div class="relative">
                <div class="absolute right-5 flex h-full items-center">
                    <svg
                        class="h-5 w-5 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        wire:loading.delay
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        />
                    </svg>
                </div>
                <input
                    @keydown.tab.prevent=""
                    @keydown.prevent.stop.enter="go()"
                    @keydown.prevent.arrow-up="selectUp()"
                    @keydown.prevent.arrow-down="selectDown()"
                    x-ref="input"
                    x-model="input"
                    type="text"
                    style="caret-color: #6b7280; border: 0 !important"
                    class="w-full appearance-none bg-transparent px-6 py-4 text-lg text-gray-300 placeholder-gray-500 outline-none focus:border-0 focus:border-transparent focus:shadow-none focus:outline-none"
                    x-bind:placeholder="inputPlaceholder"
                />
            </div>
            <div class="border-t border-gray-800" x-show="filteredItems().length > 0" style="display: none">
                <ul x-ref="results" style="max-height: 265px" class="overflow-y-auto">
                    <template x-for="(item, i) in filteredItems()" :key>
                        <li>
                            <button
                                @click="go(item[0].item.id)"
                                class="block w-full px-6 py-3 text-left"
                                :class="{ 'bg-gray-700': selected === i, 'hover:bg-gray-800': selected !== i }"
                            >
                                <span
                                    x-text="item[0].item.name"
                                    :class="{'text-gray-300': selected !== i, 'text-white': selected === i }"
                                ></span>
                                <span
                                    x-text="item[0].item.description"
                                    class="ml-1 font-normal"
                                    :class="{'text-gray-500': selected !== i, 'text-gray-400': selected === i }"
                                ></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
