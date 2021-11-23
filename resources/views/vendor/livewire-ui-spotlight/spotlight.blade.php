<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div x-data="LivewireUISpotlight({ componentId: '{{ $this->id }}', placeholder: '{{ trans('livewire-ui-spotlight::spotlight.placeholder') }}', commands: {{ $commands }} })"
         x-init="init()"
         x-show="isOpen"
         x-cloak
         @foreach(config('livewire-ui-spotlight.shortcuts') as $key)
            @keydown.window.prevent.cmd.{{ $key }}="toggleOpen()"
            @keydown.window.prevent.ctrl.{{ $key }}="toggleOpen()"
         @endforeach
         @keydown.window.escape="isOpen = false"
         @toggle-spotlight.window="toggleOpen()"
         class="fixed z-50 px-4 pt-16 flex items-start justify-center inset-0 sm:pt-24">
        <div x-show="isOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity backdrop-filter backdrop-blur-sm">
            <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
        </div>
        <div x-show="isOpen && filteredItems().length <= 0"
             x-transition:enter="ease-out delay-200 duration-300"
             x-transition:enter-start="opacity-0 -translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-50 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed flex items-center justify-center w-full h-auto px-4 pt-16 text-gray-300 transition-all transform sm:pt-24 sm:px-0">
            <template x-if="inputPlaceholder == '{{ trans('livewire-ui-spotlight::spotlight.placeholder') }}'">
                <div class="w-full max-w-lg">
                    <div class="overflow-hidden bg-gray-100 rounded-lg shadow-xl bg-opacity-20">
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez </div>
                            <div class="px-3 py-1.5 text-xs font-medium text-gray-100 uppercase bg-gray-900 rounded-lg">Article</div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher dans les articles</div>
                        </div>
                        <div class="w-full h-0 border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez </div>
                            <div class="px-3 py-1.5 text-xs font-medium text-gray-100 uppercase bg-gray-900 rounded-lg">Discussion</div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher dans les discussions</div>
                        </div>
                        <div class="w-full h-0 border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez </div>
                            <div class="px-3 py-1.5 text-xs font-medium text-gray-100 uppercase bg-gray-900 rounded-lg">Sujet</div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher un sujet dans le forum</div>
                        </div>
                        <div class="w-full h-0 border-b border-gray-300 opacity-20"></div>
                        <div class="flex items-center p-5">
                            <div class="px-2 text-sm text-gray-200">Tapez </div>
                            <div class="px-3 py-1.5 text-xs font-medium text-gray-100 uppercase bg-gray-900 rounded-lg">User</div>
                            <div class="px-2 text-sm text-gray-200">pour rechercher un utilisateur spécifique</div>
                        </div>
                    </div>
                    <div class="px-2 mt-5 text-xs text-center text-gray-200 opacity-50">ou, tapez une section pour accéder rapidement à cette page.</div>
                </div>
            </template>
            <template x-if="inputPlaceholder != '{{ trans('livewire-ui-spotlight::spotlight.placeholder') }}'">
                <div class="w-full max-w-lg p-5 bg-gray-100 rounded-lg shadow-xl bg-opacity-10">
                    <span>Suivant, </span>
                    <span x-text="inputPlaceholder" class="lowercase"></span>
                </div>
            </template>
        </div>

        <div @click.outside="isOpen = false" x-show="isOpen" x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-gray-900 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="relative">
                <div class="absolute h-full right-5 flex items-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:loading.delay>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>
                </div>
                <input @keydown.tab.prevent="" @keydown.prevent.stop.enter="go()" @keydown.prevent.arrow-up="selectUp()"
                       @keydown.prevent.arrow-down="selectDown()" x-ref="input" x-model="input"
                       type="text"
                       style="caret-color: #6b7280; border: 0 !important;"
                       class="appearance-none w-full bg-transparent px-6 py-4 text-gray-300 text-lg placeholder-gray-500 focus:border-0 focus:border-transparent focus:shadow-none outline-none focus:outline-none"
                       x-bind:placeholder="inputPlaceholder">
            </div>
            <div class="border-t border-gray-800" x-show="filteredItems().length > 0" style="display: none;">
                <ul x-ref="results" style="max-height: 265px;" class="overflow-y-auto">
                    <template x-for="(item, i) in filteredItems()" :key>
                        <li>
                            <button @click="go(item[0].item.id)" class="block w-full px-6 py-3 text-left"
                                    :class="{ 'bg-gray-700': selected === i, 'hover:bg-gray-800': selected !== i }">
                                <span x-text="item[0].item.name"
                                      :class="{'text-gray-300': selected !== i, 'text-white': selected === i }"></span>
                                <span x-text="item[0].item.description" class="ml-1 font-normal"
                                      :class="{'text-gray-500': selected !== i, 'text-gray-400': selected === i }"></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
