<div>
    <div class="lg:grid lg:grid-cols-9 lg:gap-10">
        <div class="hidden lg:block lg:col-span-2">
            <div class="sticky top-4 divide-y divide-skin-base">
                <x-articles.filter :selectedSortBy="$selectedSortBy" />

                <div class="pt-8">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-skin-link text-skin-base font-sans">
                        <svg class="mr-1.5 h-2 w-2 text-skin-base" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        Tous les tags
                    </span>

                    <div class="mt-4" aria-labelledby="posts-tags">
                        @foreach($tags as $tag)
                            <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                                <span class="text-skin-muted group-hover:hidden">#</span>
                                <svg class="mr-1.5 h-2 w-2 brand-{{ $tag->slug }} hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                <span class="truncate lowercase">{{ $tag->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div
            x-data="{
                init() {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadMore')
                            }
                        })
                    }, { root: null })

                    observer.observe(this.$el)
                }
            }"
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

                <div class="mt-4 flex justify-center">
                    @if($articles->hasMorePages())
                        <button wire:click.prevent="loadMore" class="flex items-center text-skin-base text-sm leading-5">
                            <x-loader class="text-skin-primary" />
                            Chargement...
                        </button>
                    @endif
                </div>
            </div>

            <div class="hidden lg:block lg:col-span-2">
                <div class="sticky top-4">
                    <div class="text-right">
                        <h4 class="text-skin-inverted text-sm leading-5 font-semibold uppercase tracking-wide font-sans">Sponsors</h4>
                        <div class="mt-5 space-y-4">
                            <a href="https://lotin-corp.biz" class="flex items-center justify-end">
                                <img class="w-auto h-12" src="{{ asset('images/sponsors/lotin-corp.svg') }}" alt="Lotin Corp">
                            </a>
                            <a href="https://gdg.community.dev/gdg-douala" class="flex items-center justify-end">
                                <img class="w-auto h-4" src="{{ asset('images/sponsors/gdg-douala.svg') }}" alt="GDG Douala">
                            </a>
                        </div>
                    </div>

                    <x-ads />
                </div>
            </div>
        </div>
    </div>
</div>
