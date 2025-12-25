<div>
    @php
        $next = $article->nextArticle();
        $previous = $article->previousArticle();
        $user = $article->user;
        $media = $article->getFirstMediaUrl('media');
    @endphp

    <header class="line-b section-gradient pb-6 pt-20 lg:pt-28">
        <x-container>
            {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('blog') }}

            <div class="mt-4 lg:grid lg:grid-cols-5 lg:gap-16">
                <div class="flex flex-col space-y-4 lg:col-span-3">
                    @auth
                        @if ($article->isNotPublished() && $article->isAuthoredBy(auth()->user()))
                            <div class="border-l-4 border-yellow-400 rounded-lg ring-1 ring-yellow-200 bg-yellow-50 pl-2 py-2 pr-4 dark:bg-yellow-800/20 dark:ring-yellow-800">
                                <div class="flex">
                                    <div class="shrink-0">
                                        <x-heroicon-s-exclamation-triangle class="size-5 text-yellow-400" aria-hidden="true" />
                                    </div>
                                    <div class="flex flex-1 items-center justify-between gap-4 ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            {{ __('pages/article.unpublished') }}
                                        </p>
                                        <button
                                            type="button"
                                            class="font-medium underline text-sm text-yellow-700 hover:text-yellow-600 dark:text-yellow-500 dark:hover:text-yellow-400"
                                            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form', arguments: { articleId: {{ $article->id }} }})"
                                        >
                                            {{ __('actions.edit') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <div class="flex flex-col justify-between flex-1">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <div class="inline-flex rounded-md bg-primary-50 px-2.5 py-1 ring-1 ring-primary-100 dark:bg-primary-800/20 dark:ring-primary-800">
                                <span class="text-primary-600 text-xs">
                                    {{ __('global.read_time', ['time' => $article->readTime()]) }}
                                </span>
                                </div>
                                <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">&middot;</span>
                                <span class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                                {{ __('global.page_views', ['number' => $article->views_count]) }}
                            </span>
                            </div>
                            <h1 class="mt-4 font-heading font-extrabold text-3xl text-gray-900 dark:text-white lg:text-4xl">
                                {{ $article->title }}
                            </h1>
                        </div>
                        <div class="mt-4 md:flex items-center justify-between gap-10">
                            @if ($article->tags->isNotEmpty())
                                <div class="flex items-center gap-2">
                                    @foreach ($article->tags as $tag)
                                        <x-tag :$tag />
                                    @endforeach
                                </div>
                            @endif

                            <div class="relative text-sm/6 flex mt-4 md:mt-0 items-center gap-4">
                                <x-link :href="route('profile', $article->user->username)" class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <x-user.avatar :user="$article->user" size="xs" />
                                    <span class="absolute inset-0"></span>
                                    {{ $article->user->name }}
                                </x-link>

                                @if ($article->isPublished())
                                    <div class="w-px h-4 border-l border-gray-200 dark:border-white/20"></div>
                                    <time class="capitalize text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at->format('Y-m-d') }}">
                                        {{ $article->published_at->isoFormat('LL') }}
                                    </time>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($media)
                    <div class="mt-4 lg:mt-0 lg:col-span-2">
                        <div class="relative aspect-video lg:aspect-2/1 rounded-lg shadow-lg overflow-hidden">
                            <img
                                loading="lazy"
                                class="object-cover size-full"
                                src="{{ $media }}"
                                alt="{{ $article->title }}"
                            />
                        </div>
                    </div>
                @endif
            </div>
        </x-container>
    </header>

    <x-container class="px-0 line-x">
        <div class="relative lg:grid lg:grid-cols-4">
            <div class="py-10 px-6 border-r border-line overflow-x-hidden lg:col-span-3">
                <x-markdown-content
                    id="content"
                    class="prose prose-emerald text-gray-500 prose-headings:font-heading dark:text-gray-400 dark:prose-invert lg:max-w-216 lg:mx-auto"
                    :content="$article->body"
                />
            </div>
            <div class="hidden py-6 lg:block">
                <x-sticky-content class="space-y-10">
                    @if ($article->isPublished())
                        <div class="px-6">
                            <div class="relative inline-flex mt-5 space-x-4">
                                <livewire:components.reactions
                                    wire:key="{{ $article->id }}"
                                    :model="$article"
                                />
                            </div>
                            <p class="mt-10 text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('pages/article.share_article') }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a
                                    href="https://twitter.com/share?text={{ urlencode('"' . $article->title . '" par ' . ($article->user->twitter() ? '@' . $article->user->twitter() : $article->user->name) . ' #caparledev - ') }}&url={{ urlencode(route('articles.show', $article)) }}"
                                    class="inline-flex items-center py-1.5 px-3 bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-white/20 rounded-md text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5"
                                    target="_blank"
                                >
                                    <x-phosphor-x-logo class="size-5" aria-hidden="true" />
                                </a>
                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}&quote={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                                    class="inline-flex items-center py-1.5 px-3 bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-white/20 rounded-md text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5"
                                    target="_blank"
                                >
                                    <x-phosphor-facebook-logo class="size-5" aria-hidden="true" />
                                </a>
                                <a
                                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article)) }}&title={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                                    class="inline-flex items-center py-1.5 px-3 bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-white/20 rounded-md text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5"
                                    target="_blank"
                                >
                                    <x-phosphor-linkedin-logo class="size-5" aria-hidden="true" />
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($next || $previous)
                        <div class="border-t border-line space-y-8 px-6 py-8">
                            @if ($next)
                                <div>
                                    <h5 class="text-xs uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        {{ __('pages/article.next_article') }}
                                    </h5>
                                    <div class="mt-3 flex flex-col space-y-1">
                                        <x-link
                                            class="line-clamp-2 font-medium text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                                            :href="route('articles.show', $next)"
                                        >
                                            {{ $next->title }}
                                        </x-link>
                                        <span class="text-sm text-gray-400 dark:text-gray-500">
                                            {{ __('global.read_time', ['time' => $next->readTime()]) }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if ($previous)
                                <div>
                                    <h5 class="text-xs uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        {{ __('pages/article.prev_article') }}
                                    </h5>
                                    <div class="mt-3 flex flex-col space-y-2">
                                        <x-link
                                            class="line-clamp-2 font-medium text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                                            :href="route('articles.show', $previous)"
                                        >
                                            {{ $previous->title }}
                                        </x-link>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('global.read_time', ['time' => $previous->readTime()]) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </x-sticky-content>
            </div>
        </div>
    </x-container>
</div>
