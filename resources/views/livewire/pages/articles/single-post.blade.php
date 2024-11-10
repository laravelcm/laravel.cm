<div>
    @php
        $next = $article->nextArticle();
        $previous = $article->previousArticle();
        $user = $article->user;
        $media = $article->getFirstMediaUrl('media');
    @endphp

    <x-container class="py-12 lg:pb-20">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <x-link :href="route('home')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                {{ __('global.navigation.home') }}
            </x-link>
            <span>
                <x-untitledui-slash-divider
                    class="size-4 text-gray-400 dark:text-gray-500"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
            </span>
            <x-link :href="route('articles.index')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                {{ __('global.navigation.articles') }}
            </x-link>
        </nav>

        <div class="mt-12 space-y-12 lg:mt-16 lg:space-y-20">
            <div class="lg:grid lg:grid-cols-5 lg:gap-16">
                <div class="lg:col-span-3">
                    @auth
                        @if($article->isNotPublished() && $article->isAuthoredBy(\Illuminate\Support\Facades\Auth::user()))
                            <div class="border-l-4 border-yellow-400 rounded-r-lg ring-1 ring-yellow-200 bg-yellow-50 p-4 mb-10 dark:bg-yellow-800/20 dark:ring-yellow-800">
                                <div class="flex">
                                    <div class="shrink-0">
                                        <x-heroicon-s-exclamation-triangle class="size-5 text-yellow-400" aria-hidden="true" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            {{ __('pages/article.unpublished') }}
                                            <button
                                                type="button"
                                                class="font-medium underline hover:text-yellow-600 dark:text-yellow-500 dark:hover:text-yellow-400"
                                                onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form', arguments: { articleId: {{ $article->id }} }})"
                                            >
                                                {{ __('actions.edit') }}
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    <div class="flex items-center gap-2">
                        <div class="inline-flex rounded-lg bg-primary-50 px-2.5 py-1 ring-1 ring-primary-100 dark:bg-primary-800/20 dark:ring-primary-800">
                            <span class="text-primary-600 text-xs">
                                {{ __('global.read_time', ['time' => $article->readTime()]) }}
                            </span>
                        </div>
                        <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">&middot;</span>
                        <span class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                            {{ __('global.page_views', ['number' => $article->views_count]) }}
                        </span>
                    </div>
                    <h1 class="mt-4 font-heading font-extrabold tracking-tight text-3xl text-gray-900 dark:text-white lg:text-5xl lg:leading-[3.5rem]">
                        {{ $article->title }}
                    </h1>
                    <div class="mt-8 flex items-center justify-between gap-10">
                        @if ($article->tags->isNotEmpty())
                            <div class="flex items-center gap-2">
                                @foreach ($article->tags as $tag)
                                    <x-tag :tag="$tag" />
                                @endforeach
                            </div>
                        @endif

                        <div class="relative text-sm/6 flex items-center gap-4">
                            <x-link :href="route('profile', $article->user->username)" class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <x-user.avatar
                                    :user="$article->user"
                                    class="size-6 ring-1 ring-offset-2 ring-gray-200 ring-offset-gray-50 dark:ring-white/20 dark:ring-offset-gray-900"
                                    span="-right-1 top-0 size-3 ring-1"
                                />
                                <span class="absolute inset-0"></span>
                                {{ $article->user->name }}
                            </x-link>
                            @if($article->isPublished())
                                <div class="w-[1px] h-4 border-l border-gray-200 dark:border-white/20"></div>
                                <time class="capitalize text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at->format('Y-m-d') }}">
                                    {{ $article->published_at->isoFormat('LL') }}
                                </time>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($media)
                    <div class="mt-4 lg:mt-0 lg:col-span-2">
                        <div class="relative aspect-[16/9] lg:aspect-[2/1] rounded-xl shadow-lg overflow-hidden">
                            <img
                                class="object-cover size-full"
                                src="{{ $media }}"
                                alt="{{ $article->title }}"
                            />
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:grid lg:grid-cols-4 lg:gap-16">
                <div class="overflow-x-hidden lg:col-span-3">
                    <x-markdown-content
                        id="content"
                        class="prose prose-green text-gray-500 dark:text-gray-400 dark:prose-invert lg:max-w-none"
                        :content="$article->body"
                    />
                </div>
                <div class="hidden lg:block">
                    <x-sticky-content class="space-y-10">
                        @if($article->isPublished())
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ __('pages/article.share_article') }}
                                </p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a
                                        href="https://twitter.com/share?text={{ urlencode('"' . $article->title . '" par ' . ($article->user->twitter() ? '@' . $article->user->twitter() : $article->user->name) . ' #caparledev - ') }}&url={{ urlencode(route('articles.show', $article)) }}"
                                        class="inline-flex items-center py-2 px-4 bg-white border-0 ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900"
                                        target="_blank"
                                    >
                                        <x-icon.twitter class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                    </a>
                                    <a
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}&quote={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                                        class="inline-flex items-center py-2 px-4 bg-white border-0 ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900"
                                        target="_blank"
                                    >
                                        <x-icon.facebook class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                    </a>
                                    <a
                                        href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article)) }}&title={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                                        class="inline-flex items-center py-2 px-4 bg-white border-0 ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900"
                                        target="_blank"
                                    >
                                        <x-icon.linkedin class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($next || $previous)
                            <div class="border-gray-200 border-t space-y-8 py-8 dark:border-white/10">
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
                                        <div class="mt-3 flex flex-col space-y-1">
                                            <x-link
                                                class="line-clamp-2 font-medium text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                                                :href="route('articles.show', $previous)"
                                            >
                                                {{ $previous->title }}
                                            </x-link>
                                            <span class="text-sm text-gray-400 dark:text-gray-500">
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
        </div>
    </x-container>
</div>
