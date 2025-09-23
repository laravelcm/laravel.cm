<x-container class="py-12 lg:pb-20">
    <div class="relative lg:grid lg:grid-cols-7 lg:gap-20">
        <div class="lg:col-span-5 space-y-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between sm:gap-10">
                <x-scrollable-content
                    class="bg-white rounded-xl ring-1 ring-gray-200/60 dark:bg-gray-800 dark:ring-white/10 sm:w-2/3"
                    tab-class="!pb-0"
                >
                    <div class="border-b border-gray-200">
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
                    </div>
                </x-scrollable-content>

                <div class="flex items-center gap-2">
                    <span wire:loading>
                        <x-loader class="text-flag-green" />
                    </span>

                    <x-filament::dropdown>
                        <x-slot name="trigger">
                            <button type="button" class="inline-flex items-center p-2 rounded-lg bg-white text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 dark:bg-gray-800 ring-1 ring-gray-200/80 dark:ring-white/20">
                                <x-untitledui-filter-funnel class="size-5" stroke-width="1.5" aria-hidden="true" />
                            </button>
                        </x-slot>

                        <x-filament::dropdown.list>
                            <x-filament::dropdown.list.item wire:click="sort('recent')">
                                {{ __('pages/discussion.filter.recent') }}
                            </x-filament::dropdown.list.item>
                            <x-filament::dropdown.list.item wire:click="sort('popular')">
                                {{ __('pages/discussion.filter.popular') }}
                            </x-filament::dropdown.list.item>
                            <x-filament::dropdown.list.item wire:click="sort('active')">
                                {{ __('pages/discussion.filter.active') }}
                            </x-filament::dropdown.list.item>
                        </x-filament::dropdown.list>
                    </x-filament::dropdown>

                    <x-locale-selector :$locale />

                    @can('create', \App\Models\Discussion::class)
                        <x-buttons.primary
                            type="button"
                            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
                            class="gap-2 w-full justify-center py-2.5"
                        >
                            {{ __('actions.start') }}
                        </x-buttons.primary>
                    @endcan
                </div>
            </div>

            <div class="divide-y divide-gray-200/60 dark:divide-gray-700">
                @foreach ($discussions as $discussion)
                    <x-discussions.overview :$discussion />
                @endforeach
            </div>

            {{ $discussions->links() }}
        </div>

        <div class="relative hidden lg:col-span-2 lg:block">
            @include('partials._contributions')
        </div>
    </div>
</x-container>
