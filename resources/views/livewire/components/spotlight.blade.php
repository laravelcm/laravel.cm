@php
    $grouped = collect($commands)->groupBy('group');
@endphp

<div
    x-data="SpotlightComponent({
        commands: @js($commands),
        componentId: '{{ $this->getId() }}',
    })"
    x-init="init()"
    x-on:keydown.window.prevent.cmd.k="toggleOpen()"
    x-on:keydown.window.prevent.ctrl.k="toggleOpen()"
    x-on:keydown.window.escape="isOpen && goBack()"
    x-on:open-spotlight.window="!isOpen && toggleOpen()"
    @close-spotlight.window="isOpen = false"
    x-cloak
>
    <template x-teleport="body">
        <div x-show="isOpen" class="relative z-50">
            <div
                x-show="isOpen"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/25 transition-opacity dark:bg-gray-900/50"
                @click="isOpen = false"
            ></div>

            <div
                class="fixed inset-0 w-screen overflow-y-auto p-4 sm:p-6 md:p-20"
                @click.self="isOpen = false"
            >
                <div
                    x-show="isOpen"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5 transition-all dark:bg-gray-900 dark:ring-white/10"
                >
                    <div class="divide-y divide-gray-100 dark:divide-white/10">
                        <div class="flex items-center">
                            <template x-if="isInDependencyMode">
                                <div class="flex items-center pl-4 gap-2 shrink-0">
                                    <button type="button" @click="goBack()" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                        <x-heroicon-o-x-circle class="size-5" />
                                    </button>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="selectedCommand.name"></span>
                                    <span class="text-gray-300 dark:text-gray-600">/</span>
                                </div>
                            </template>
                            <template x-if="!isInDependencyMode">
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="pointer-events-none ml-4 size-5 shrink-0 text-gray-400 dark:text-gray-500">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                </svg>
                            </template>
                            <input
                                x-ref="input"
                                x-model="input"
                                type="search"
                                autofocus
                                :placeholder="isInDependencyMode ? currentDependency?.placeholder : '{{ __('command-palette.placeholder') }}...'"
                                class="h-12 w-full min-w-0 flex-1 pr-4 pl-3 text-base text-gray-900 outline-none ring-0 border-none placeholder:text-gray-400 sm:text-sm dark:bg-transparent dark:text-white dark:placeholder:text-gray-500"
                                @keydown.tab.prevent
                                @keydown.enter.prevent.stop="go()"
                                @keydown.arrow-up.prevent="selectUp()"
                                @keydown.arrow-down.prevent="selectDown()"
                            />
                            <div class="flex items-center pr-4 shrink-0" wire:loading.delay>
                                <svg class="animate-spin size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>

                        <div x-show="!isInDependencyMode && visibleIds().length > 0" x-ref="commandResults" class="flex max-h-80 scroll-py-10 scroll-pb-2 flex-col gap-4 overflow-y-auto p-4 pb-2">
                            @foreach ($grouped as $group => $items)
                                <div x-show="groupHasVisibleItems('{{ $group }}')">
                                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ __('command-palette.groups.' . $group, [], app()->getLocale()) !== 'command-palette.groups.' . $group ? __('command-palette.groups.' . $group) : ucfirst($group) }}
                                    </h2>
                                    <div class="-mx-4 mt-2 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach ($items as $cmd)
                                            <button
                                                type="button"
                                                data-spotlight-item
                                                x-show="isVisible('{{ $cmd['id'] }}')"
                                                @click="go('{{ $cmd['id'] }}')"
                                                class="group flex w-full cursor-default items-center px-4 py-2 select-none text-left focus:outline-hidden"
                                                :class="isSelected('{{ $cmd['id'] }}')
                                                    ? 'bg-primary-600 text-white dark:bg-primary-500'
                                                    : 'hover:bg-gray-100 dark:hover:bg-white/5'"
                                            >
                                                @if ($cmd['icon'])
                                                    <x-dynamic-component
                                                        :component="$cmd['icon']"
                                                        class="size-6 flex-none"
                                                        ::class="isSelected('{{ $cmd['id'] }}')
                                                            ? 'text-white'
                                                            : 'text-gray-400 dark:text-gray-500'"
                                                    />
                                                @endif
                                                <span class="ml-3 flex-auto truncate">{{ $cmd['name'] }}</span>
                                                @if ($cmd['description'])
                                                    <span
                                                        class="ml-3 flex-none text-xs"
                                                        :class="isSelected('{{ $cmd['id'] }}')
                                                            ? 'text-white/70'
                                                            : 'text-gray-400 dark:text-gray-500'"
                                                    >{{ $cmd['description'] }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div x-show="isInDependencyMode && dependencyResults().length > 0" x-ref="dependencyResultsList" class="max-h-80 scroll-py-2 overflow-y-auto p-4 pb-2">
                            <h2 class="text-xs font-semibold text-gray-900 dark:text-white" x-text="selectedCommand.name"></h2>
                            <div class="-mx-4 mt-2 text-sm text-gray-700 dark:text-gray-300">
                                <template x-for="([result, i]) in dependencyResults()" :key="result.item.id">
                                    <button
                                        type="button"
                                        data-spotlight-item
                                        @click="go(result.item.id)"
                                        class="group flex w-full cursor-default items-center px-4 py-2 select-none text-left focus:outline-hidden"
                                        :class="i === selected
                                            ? 'bg-primary-600 text-white dark:bg-primary-500'
                                            : 'hover:bg-gray-100 dark:hover:bg-white/5'"
                                    >
                                        <span class="flex-auto truncate" x-text="result.item.name"></span>
                                        <span
                                            x-show="result.item.description"
                                            x-text="result.item.description"
                                            class="ml-3 flex-none text-xs"
                                            :class="i === selected ? 'text-white/70' : 'text-gray-400 dark:text-gray-500'"
                                        ></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div x-show="!isInDependencyMode && input.length > 0 && visibleIds().length === 0" class="px-6 py-14 text-center text-sm">
                            <x-heroicon-o-exclamation-triangle class="mx-auto size-6 text-gray-400 dark:text-gray-500" />
                            <p class="mt-4 font-semibold text-gray-900 dark:text-white">{{ __('command-palette.no_results') }}</p>
                        </div>

                        <div x-show="isInDependencyMode && input.length >= 2 && dependencyResults().length === 0" class="px-6 py-14 text-center text-sm" wire:loading.remove>
                            <x-heroicon-o-exclamation-triangle class="mx-auto size-6 text-gray-400 dark:text-gray-500" />
                            <p class="mt-4 font-semibold text-gray-900 dark:text-white">{{ __('command-palette.no_results') }}</p>
                        </div>

                        <div class="flex flex-wrap items-center bg-gray-50 px-4 py-2.5 text-xs text-gray-700 dark:bg-gray-800/50 dark:text-gray-300">
                            <kbd class="px-1 py-0.5 flex items-center justify-center rounded-sm ring-1 ring-gray-400 bg-white font-semibold text-gray-900 mr-2 dark:ring-white/10 dark:bg-gray-800 dark:text-white">esc</kbd>
                            <span x-text="isInDependencyMode ? '{{ __('command-palette.back') }}' : '{{ __('command-palette.close') }}'"></span>
                            <span class="flex-1"></span>
                            <kbd class="mx-2 flex size-5 items-center justify-center rounded-sm ring-1 ring-gray-400 bg-white font-semibold text-gray-900 dark:ring-white/10 dark:bg-gray-800 dark:text-white">↵</kbd>
                            <span>{{ __('command-palette.select') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
