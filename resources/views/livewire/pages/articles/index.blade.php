<div>
    <div class="relative bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <x-container class="relative flex items-center justify-between py-12 sm:py-16">
            <div class="max-w-xl">
                <h1 class="font-heading font-bold text-3xl text-gray-900 dark:text-white">
                    {{ __('pages/article.blog') }}
                </h1>
                <p class="mt-1.5 text-lg text-gray-500 dark:text-gray-400">
                    {{ __('pages/article.blog_summary') }}
                </p>
            </div>
            <div class="hidden lg:block">
                @include('ads.ln')
            </div>
        </x-container>
        <div class="border-b border-gray-100 dark:border-white/10">
            <x-container
                x-data="{
                    displayLeftArrow: false,
                    displayRightArrow: true,
                    element: document.getElementById('tags'),
                    currentTab: document
                        .getElementById('tags')
                        .querySelector('.current'),

                    slideLeft() {
                        this.element.scrollLeft -= 100
                        this.onScroll()
                    },
                    slideRight() {
                        this.element.scrollLeft += 100
                        this.onScroll()
                    },
                    onScroll() {
                        this.displayLeftArrow = this.element.scrollLeft >= 20
                        let maxScrollPosition =
                            this.element.scrollWidth - this.element.clientWidth - 20
                        this.displayRightArrow = this.element.scrollLeft <= maxScrollPosition
                    },
                    scrollToActive() {
                        if (this.currentTab) {
                            this.element.scrollLeft = this.currentTab.offsetLeft - 50
                        }
                    },
                }"
                x-init="scrollToActive()"
                class="relative overflow-hidden"
            >
                <div
                    x-cloak
                    x-show="displayLeftArrow"
                    x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="-translate-x-2 opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition duration-300 ease-in"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="-translate-x-2 opacity-0"
                    class="absolute top-0 flex h-full w-32 items-center justify-start bg-gradient-to-r from-white px-2.5 dark:from-gray-800"
                >
                    <button
                        @click="slideLeft()"
                        type="button"
                        class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-500"
                    >
                        <x-untitledui-chevron-left class="size-6" aria-hidden="true" />
                    </button>
                </div>

                <nav
                    @scroll="onScroll()"
                    class="hide-scroll -mb-px flex items-center space-x-2 overflow-x-auto scroll-smooth pb-2 pl-4 pr-10"
                    aria-label="Tabs"
                    id="tags"
                >
                    @foreach($tags as $tag)
                        <x-link
                            :href="route('articles.tag', $tag)"
                            class="inline-flex items-center rounded-lg py-1.5 px-3 text-nowrap gap-2 text-gray-500 transition-colors duration-200 ease-in-out hover:bg-gray-50 hover:text-gray-700 dark:hover:bg-gray-900/70 dark:text-gray-400 dark:hover:text-white"
                        >
                            <x-dynamic-component :component="'icon.tags.'. $tag->slug()" class="size-5" aria-hidden="true" />
                            {{ $tag->name }}
                        </x-link>
                    @endforeach
                </nav>

                <div
                    x-show="displayRightArrow"
                    x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="translate-x-2 opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition duration-300 ease-in"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-2 opacity-0"
                    class="absolute right-0 top-0 flex h-full w-32 items-center justify-end bg-gradient-to-l from-white px-2.5 dark:from-gray-800"
                >
                    <button
                        @click="slideRight()"
                        type="button"
                        class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-500"
                    >
                        <x-untitledui-chevron-right class="size-6" aria-hidden="true" />
                    </button>
                </div>
            </x-container>
        </div>
    </div>

    <x-container x-data x-intersect="@this.call('loadMore')" class="py-12 lg:py-16">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-y-12">
            @foreach ($articles as $article)
                <x-articles.card-author :article="$article" wire:key="{{ $article->slug() }}" />
            @endforeach
        </div>

        @if ($articles->hasMorePages())
            <p x-intersect="@this.call('loadMore')" class="mt-10 flex items-center justify-center gap-2">
                <x-loader class="text-primary-600" aria-hidden="true" />
                {{ __('global.loading') }}
            </p>
        @endif
    </x-container>
</div>
