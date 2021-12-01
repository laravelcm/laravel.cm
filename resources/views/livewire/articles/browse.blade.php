<div>
    <div class="lg:grid lg:grid-cols-9 lg:gap-10">
        <div class="hidden lg:block lg:col-span-2">
            <div class="sticky top-4 divide-y divide-skin-base">
                <x-articles.filter :selectedSortBy="$selectedSortBy" />

                <div class="pt-8">
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-sm font-medium bg-skin-link text-skin-base font-sans">
                        <svg class="mr-1.5 h-2 w-2 text-skin-base" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        Tous les tags
                    </span>

                    <x-tags :tags="$tags" :selected-tag="$selectedTag" isLowercase showHashTag />
                </div>
            </div>
        </div>
        <div
            x-data
            x-intersect="@this.call('loadMore')"
            class="lg:grid lg:grid-cols-8 lg:gap-8 lg:col-span-7"
        >
            <div class="lg:col-span-6">
                <div class="pb-5 border-b border-skin-base">
                    <h1 class="text-3xl leading-8 font-extrabold text-skin-inverted font-sans">
                        Récentes publications
                    </h1>
                    <p class="mt-2 max-w-4xl text-sm text-skin-base leading-5 font-sans">Tous les articles récemment publiés.</p>
                </div>

                <x-articles.filter :selectedSortBy="$selectedSortBy" forMobile/>

                <div class="py-12 space-y-8 sm:space-y-10 max-w-lg mx-auto lg:max-w-none">
                    @foreach ($articles as $article)
                        <x-articles.overview :article="$article" />
                    @endforeach
                </div>

                @if($articles->hasMorePages())
                    <div
                        x-data
                        x-intersect="@this.call('loadMore')"
                        class="mt-5 flex justify-center"
                    >
                        <p class="flex items-center">
                            <x-loader class="text-skin-primary" />
                            Chargement...
                        </p>
                    </div>
                @endif
            </div>

            <div class="hidden lg:block lg:col-span-2">
                <div class="sticky top-4 space-y-12">
                    <x-sponsors />

                    <x-ads />
                </div>
            </div>
        </div>
    </div>
</div>
