<x-container class="px-0 lg:line-x">
    <div class="relative pt-20 pb-16 lg:pt-28 lg:grid lg:grid-cols-7">
        <div class="lg:col-span-5 space-y-10">
            <div class="flex flex-col bg-white sticky z-10 dark:bg-gray-950/75 border-y border-l border-line gap-4 sm:flex-row sm:items-stretch sm:justify-between sm:gap-10" style="top: calc(4rem + var(--banner-height))">
                <x-scrollable-content class="sm:w-2/3 border-r border-line">
                    <nav class="flex items-center space-x-3">
                        @foreach ($tags as $tag)
                            <button
                                type="button"
                                @if ($tag->slug === $currentTag)
                                    aria-current="page"
                                @endif
                                @class([
                                    'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium',
                                    'border-primary-500 text-primary-600 dark:text-primary-500 current' => $tag->slug === $currentTag,
                                    'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-700 hover:text-gray-700 dark:hover:text-gray-300' => $tag->slug !== $currentTag,
                                ])
                                wire:click="toggleTag('{{ $tag->slug }}')"
                            >
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </nav>
                </x-scrollable-content>

                <div class="hidden lg:flex items-center gap-2 px-4">
                    <span wire:loading>
                        <x-loader class="text-flag-green" />
                    </span>

                    <el-dropdown class="inline-block">
                        <button class="flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <x-untitledui-filter-funnel class="size-5" stroke-width="1.5" aria-hidden="true" />
                        </button>

                        <el-menu
                            anchor="bottom end"
                            popover
                            class="w-56 origin-top-right rounded-md bg-white dark:bg-gray-950/75 shadow-lg outline-1 outline-black/5 dark:outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in"
                        >
                            <div class="py-1">
                                @foreach (['recent', 'popular', 'active'] as $filter)
                                    <button type="button" wire:click="sort('{{ $filter }}')" class="flex w-full px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:text-white dark:hover:bg-white/5">
                                        {{ __("pages/discussion.filter.{$filter}") }}
                                    </button>
                                @endforeach
                            </div>
                        </el-menu>
                    </el-dropdown>

                    <x-locale-selector :$locale class="h-9" />

                    @can('create', App\Models\Discussion::class)
                        <flux:button
                            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
                            class="border-0"
                            variant="primary"
                        >
                            {{ __('actions.start') }}
                        </flux:button>
                    @endcan
                </div>
            </div>

            <div class="divide-y divide-gray-300/50 dark:divide-white/20">
                @foreach ($discussions as $discussion)
                    <x-discussions.overview :$discussion class="px-4" />
                @endforeach
            </div>

            <div class="px-4">
                {{ $discussions->links() }}
            </div>
        </div>

        <div class="hidden relative border-l border-y border-line lg:col-span-2 lg:block">
            <x-sticky-content class="space-y-8 bg-dotted after:border-0">
                <livewire:components.discussion.top-contributors />

                <livewire:components.discussion.no-comment-discussions />
            </x-sticky-content>
        </div>
    </div>
</x-container>
