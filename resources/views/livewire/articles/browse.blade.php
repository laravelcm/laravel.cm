<div class="lg:grid lg:grid-cols-9 lg:gap-10">
    <div class="hidden lg:block lg:col-span-2">
        <x-sticky-content class="divide-y divide-skin-base">
            <div class="pb-8">
                <h4 class="text-skin-inverted text-base leading-6 font-medium">Affichage des articles</h4>
                <div class="mt-5 flex items-center space-x-3">
                    <x-view-mode mode="list" :isViewMode="$viewMode === 'list'">
                        <svg class="h-5 w-5 mr-2 text-skin-base/60" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M17.8 10C18.9201 10 19.4802 10 19.908 9.78201C20.2843 9.59027 20.5903 9.28431 20.782 8.90798C21 8.48016 21 7.92011 21 6.8V6.2C21 5.0799 21 4.51984 20.782 4.09202C20.5903 3.7157 20.2843 3.40973 19.908 3.21799C19.4802 3 18.9201 3 17.8 3L6.2 3C5.0799 3 4.51984 3 4.09202 3.21799C3.71569 3.40973 3.40973 3.71569 3.21799 4.09202C3 4.51984 3 5.07989 3 6.2L3 6.8C3 7.9201 3 8.48016 3.21799 8.90798C3.40973 9.28431 3.71569 9.59027 4.09202 9.78201C4.51984 10 5.07989 10 6.2 10L17.8 10Z" />
                            <path d="M17.8 21C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V17.2C21 16.0799 21 15.5198 20.782 15.092C20.5903 14.7157 20.2843 14.4097 19.908 14.218C19.4802 14 18.9201 14 17.8 14L6.2 14C5.0799 14 4.51984 14 4.09202 14.218C3.71569 14.4097 3.40973 14.7157 3.21799 15.092C3 15.5198 3 16.0799 3 17.2L3 17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21H17.8Z" />
                        </svg>
                        Liste
                    </x-view-mode>
                    <x-view-mode mode="card" :isViewMode="$viewMode === 'card'">
                        <svg class="h-5 w-5 mr-2 text-skin-base/60" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M3 15h18M7.8 3h8.4c1.68 0 2.52 0 3.162.327a3 3 0 0 1 1.311 1.311C21 5.28 21 6.12 21 7.8v8.4c0 1.68 0 2.52-.327 3.162a3 3 0 0 1-1.311 1.311C18.72 21 17.88 21 16.2 21H7.8c-1.68 0-2.52 0-3.162-.327a3 3 0 0 1-1.311-1.311C3 18.72 3 17.88 3 16.2V7.8c0-1.68 0-2.52.327-3.162a3 3 0 0 1 1.311-1.311C5.28 3 6.12 3 7.8 3Z" />
                        </svg>
                        Card
                    </x-view-mode>
                </div>
            </div>
            <div class="py-8">
                <h4 class="text-skin-inverted text-base leading-6 font-medium">Tous les tags</h4>

                <x-tags :tags="$tags" :selected-tag="$selectedTag" isLowercase showHashTag />
            </div>
        </x-sticky-content>
    </div>
    <div
        x-data
        x-intersect="@this.call('loadMore')"
        class="lg:grid lg:grid-cols-8 lg:gap-8 lg:col-span-7"
    >
        <div class="lg:col-span-6">
            <div class="pb-5 border-b border-skin-base">
                <h1 class="text-3xl leading-8 font-extrabold text-skin-inverted font-heading">
                    Récentes publications
                </h1>
                <p class="mt-2 max-w-4xl text-skin-base leading-5">Tous les articles récemment publiés.</p>
            </div>

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
            <x-sticky-content class="space-y-12">
                <x-sponsors />

                <x-ads />

                <x-discord />
            </x-sticky-content>
        </div>
    </div>
</div>
