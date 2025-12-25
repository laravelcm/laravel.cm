<div>
    <div class="line-b section-gradient pt-20 pb-16 lg:pt-28">
        <x-container class="relative flex items-center justify-between">
            <div class="max-w-xl">
                <h1 class="font-heading font-bold text-3xl text-gray-900 dark:text-white">
                    {{ __('pages/article.blog') }}
                </h1>
                <p class="mt-1.5 text-lg text-gray-500 dark:text-gray-400">
                    {{ __('pages/article.blog_summary') }}
                </p>
                <div class="mt-4 flex items-center gap-2">
                    <x-locale-selector :$locale />
                    <span wire:loading>
                        <x-loader class="text-flag-green" />
                    </span>
                </div>
            </div>
        </x-container>
    </div>

    <div class="border-b border-gray-100 dark:border-white/10 lg:hidden">
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
            class="relative overflow-hidden px-0"
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
                class="absolute top-0 flex h-full w-32 items-center justify-start bg-linear-to-r from-white px-2.5 dark:from-gray-800"
            >
                <button
                    @click="slideLeft()"
                    type="button"
                    class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-500"
                >
                    <x-untitledui-chevron-left class="size-6" aria-hidden="true" />
                </button>
            </div>

            <nav
                @scroll="onScroll()"
                class="hide-scroll -mb-px flex items-center overflow-x-auto scroll-smooth py-2 pl-4 pr-10"
                aria-label="Tabs"
                id="tags"
            >
                @foreach ($tags as $tag)
                    <x-link
                        :href="route('articles.tag', $tag)"
                        class="inline-flex items-center rounded-lg py-1.5 px-3 text-nowrap gap-2 text-gray-500 transition-colors duration-200 ease-in-out hover:bg-gray-50 hover:text-gray-700 dark:hover:bg-gray-900/70 dark:text-gray-400 dark:hover:text-white"
                    >
                        <x-dynamic-component :component="'icon.tags.'. $tag->slug" class="size-5" aria-hidden="true" />
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
                class="absolute right-0 top-0 flex h-full w-32 items-center justify-end bg-linear-to-l from-white px-2.5 dark:from-gray-800"
            >
                <button
                    @click="slideRight()"
                    type="button"
                    class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-500"
                >
                    <x-untitledui-chevron-right class="size-6" aria-hidden="true" />
                </button>
            </div>
        </x-container>
    </div>

    <x-container class="px-0">
        <div class="py-12 lg:line-x lg:py-12">
            <div class="grid border-t border-line lg:grid-cols-4">
                <div class="hidden border-gray-300 border-r border-dotted dark:border-white/20 lg:block">
                    <x-sticky-content class="top-16">
                        <div>
                            <div class="flex items-start gap-4 px-4 py-2 bg-gray-50 dark:bg-gray-950/50">
                                <x-phosphor-bookmarks-duotone
                                    class="size-4 shrink-0 text-primary-600 dark:text-primary-500"
                                    aria-hidden="true"
                                />
                                <p class="text-gray-700 dark:text-gray-400 text-xs font-mono uppercase">
                                    {{ __('pages/article.tags') }}
                                </p>
                            </div>
                            <ul role="listbox" class="border-y border-line">
                                @foreach ($tags as $tag)
                                    <li class="relative ml-px px-4 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-white/5">
                                        <x-dynamic-component :component="'icon.tags.'. $tag->slug" class="size-5" aria-hidden="true" />
                                        <x-link
                                            :href="route('articles.tag', $tag)"
                                            class="inline-flex border-l border-line pl-4 py-2 text-sm text-nowrap gap-2 text-gray-500  hover:text-gray-700  dark:text-gray-400 dark:hover:text-white"
                                        >
                                            <span class="absolute inset-0"></span>
                                            {{ $tag->name }}
                                        </x-link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <div class="flex items-start gap-4 px-4 py-2 bg-gray-50 dark:bg-gray-950/50">
                                <x-phosphor-trophy-duotone
                                    class="size-4 shrink-0 text-primary-600 dark:text-primary-500"
                                    aria-hidden="true"
                                />
                                <p class="text-gray-700 dark:text-gray-400 text-xs font-mono uppercase">
                                    {{ __('pages/article.top_authors') }}
                                </p>
                            </div>
                            <ul role="listbox" class="border-y border-line">
                                @foreach ($this->topAuthors as $author)
                                    <li class="relative ml-px px-4 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-white/5">
                                        <x-user.avatar :user="$author" size="xs" />
                                        <x-link
                                            :href="route('profile', $author->username)"
                                            class="flex-1 flex items-center justify-between border-l border-line pl-4 py-2 text-sm gap-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
                                        >
                                            <span class="absolute inset-0"></span>
                                            <span class="truncate flex-1">{{ $author->name }}</span>
                                            <span class="inline-block text-xs font-mono uppercase font-medium text-primary-600 dark:text-primary-400">
                                            {{ $author->articles_count }}
                                        </span>
                                        </x-link>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </x-sticky-content>
                </div>
                <div class="lg:col-span-3">
                    <div class="grid border-line sm:grid-cols-2 *:border-b *:border-line sm:[&>*:nth-child(odd)]:border-r">
                        @foreach ($articles as $article)
                            <x-articles.card-author :$article wire:key="{{ $article->slug }}" />
                        @endforeach
                    </div>

                    <div class="p-6 border-b border-line">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</div>
