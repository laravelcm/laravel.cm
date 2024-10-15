<div class="lg:grid lg:grid-cols-9 lg:gap-10">
    <div class="hidden lg:col-span-2 lg:block">
        <x-sticky-content class="divide-y divide-skin-base">
            <div class="pb-8">
                <h4 class="text-base font-medium leading-6 text-gray-900">Affichage des articles</h4>
                <div class="mt-5 flex items-center space-x-3">
                    <x-view-mode mode="list" :isViewMode="$viewMode === 'list'">
                        <svg
                            class="mr-2 size-5 text-gray-500 dark:text-gray-400/60"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"
                            />
                        </svg>
                        Liste
                    </x-view-mode>
                    <x-view-mode mode="card" :isViewMode="$viewMode === 'card'">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mr-2 size-5 text-gray-500 dark:text-gray-400/60"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122"
                            />
                        </svg>
                        Carte
                    </x-view-mode>
                </div>
            </div>
            <div class="py-8">
                <h4 class="text-base font-medium leading-6 text-gray-900">Tous les tags</h4>
                <x-tags :tags="$tags" :selected-tag="$selectedTag" :showTagsColor="false" showTagsIcon />
            </div>
        </x-sticky-content>
    </div>
    <div x-data x-intersect="@this.call('loadMore')" class="lg:col-span-7 lg:grid lg:grid-cols-8 lg:gap-8">
        <div class="lg:col-span-6">
            <div class="border-b border-skin-base pb-5">
                <h1 class="font-heading text-3xl font-extrabold leading-8 text-gray-900">Récentes publications</h1>
                <p class="mt-2 max-w-4xl leading-5 text-gray-500 dark:text-gray-400">Tous les articles récemment publiés.</p>
            </div>

            <div class="mx-auto max-w-lg space-y-8 py-12 sm:space-y-10 lg:max-w-none">
                @foreach ($articles as $article)
                    @if ($viewMode === 'card')
                        <x-articles.card-with-author :article="$article" />
                    @else
                        <x-articles.overview :article="$article" />
                    @endif
                @endforeach
            </div>

            @if ($articles->hasMorePages())
                <div x-data x-intersect="@this.call('loadMore')" class="mt-5 flex justify-center">
                    <p class="flex items-center">
                        <x-loader class="text-primary-600" />
                        Chargement...
                    </p>
                </div>
            @endif
        </div>

        <div class="hidden lg:col-span-2 lg:block">
            <x-sticky-content class="space-y-12">
                <x-sponsors />
                <x-ads />
                <x-discord />
            </x-sticky-content>
        </div>
    </div>
</div>
