<x-app-layout :title="$article->title">
    @php
        $next = $article->nextArticle();
        $previous = $article->previousArticle();
        $user = $article->user;
    @endphp

    <x-container class="py-12">
        <article class="relative lg:grid lg:grid-cols-9 lg:gap-10">
            <div class="relative hidden lg:col-span-2 lg:block">
                <x-sticky-content class="space-y-6 divide-y divide-gray-200 dark:divide-white/20">
                    <div>
                        <h4 class="font-heading text-xs font-medium uppercase leading-4 tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('pages/article.about_author') }}
                        </h4>
                        <div class="mt-6 space-y-4">
                            <x-link :href="route('profile', $user->username)" class="block shrink-0">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <x-user.avatar :user="$user" class="size-9" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ '@' . $user->username }}
                                        </p>
                                    </div>
                                </div>
                            </x-link>
                            @if ($user->bio)
                                <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">{{ $user->bio }}</p>
                            @endif

                            <div class="flex space-x-3">
                                @if ($user->twitter())
                                    <a
                                        href="https://twitter.com/{{ $user->twitter() }}"
                                        class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                        target="_blank"
                                    >
                                        <span class="sr-only">Twitter</span>
                                        <x-icon.twitter class="size-6" aria-hidden="true" />
                                    </a>
                                @endif

                                @if ($user->linkedin())
                                    <a
                                        href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                        class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                        target="_blank"
                                    >
                                        <span class="sr-only">LinkedIn</span>
                                        <x-icon.linkedin class="size-6" aria-hidden="true" />
                                    </a>
                                @endif

                                @if ($user->githubUsername())
                                    <a
                                        href="https://github.com/{{ $user->githubUsername() }}"
                                        class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                        target="_blank"
                                    >
                                        <span class="sr-only">GitHub</span>
                                        <x-icon.github class="size-6" aria-hidden="true" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($next || $previous)
                        <div class="space-y-6 pt-6">
                            @if ($next)
                                <div>
                                    <h4 class="text-xs font-medium uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        {{ __('pages/article.next_article') }}
                                    </h4>
                                    <x-link
                                        :href="route('articles.show', $next)"
                                        class="mt-3 group flex items-start gap-2"
                                    >
                                        <img
                                            class="size-8 rounded-lg object-cover shadow-lg"
                                            src="{{ $next->getFirstMediaUrl('media') }}"
                                            alt="{{ $next->slug }}"
                                        />
                                        <span class="line-clamp-2 text-sm font-medium leading-4 text-gray-900 group-hover:text-primary-600 dark:text-white dark:group-hover:text-primary-500 transition-colors duration-150 ease-in-out">
                                            {{ $next->title }}
                                        </span>
                                    </x-link>
                                </div>
                            @endif

                            @if ($previous)
                                <div>
                                    <h4 class="text-xs font-medium uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        {{ __('pages/article.prev_article') }}
                                    </h4>
                                    <x-link
                                        :href="route('articles.show', $previous)"
                                        class="mt-3 group flex items-start space-x-2"
                                    >
                                        <img
                                            class="size-8 rounded-md object-cover shadow-lg"
                                            src="{{ $previous->getFirstMediaUrl('media') }}"
                                            alt="{{ $previous->slug }}"
                                        />
                                        <span class="line-clamp-2 text-sm font-medium leading-4 text-gray-900 group-hover:text-primary-600 dark:text-white dark:group-hover:text-primary-500 transition-colors duration-150 ease-in-out">
                                            {{ $previous->title }}
                                        </span>
                                    </x-link>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="pt-6">
                        <livewire:reactions :model="$article" />
                    </div>
                </x-sticky-content>
            </div>
            <div class="lg:col-span-5">
                <header class="space-y-4">
                    <div class="sm:flex sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-3">
                            @if ($article->tags->isNotEmpty())
                                <div class="flex items-center space-x-2">
                                    @foreach ($article->tags as $tag)
                                        <x-tag :tag="$tag" />
                                    @endforeach
                                </div>
                            @endif

                            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
                        </div>

                        <div class="mt-2 flex space-x-1 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                            <time class="capitalize" datetime="{{ $article->publishedAt()->format('Y-m-d') }}">
                                {{ $article->publishedAt()->isoFormat('LL') }}
                            </time>
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ __('global.read_time', ['time' => $article->readTime()]) }}</span>
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ __('global.page_views', ['number' => $article->views_count]) }}</span>
                        </div>
                    </div>
                    <h1
                        class="font-heading text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl sm:leading-10 md:text-4xl lg:text-5xl lg:leading-[3.5rem]"
                    >
                        {{ $article->title }}
                    </h1>
                    <x-link
                        :href="route('profile', $article->user->username)"
                        class="group mt-3 block shrink-0 lg:hidden"
                    >
                        <div class="flex items-center">
                            <div>
                                <img
                                    class="inline-block size-8 rounded-full"
                                    src="{{ $article->user->profile_photo_url }}"
                                    alt="{{ $article->user->username }}"
                                />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $article->user->name }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ '@' . $article->user->username }}
                                </p>
                            </div>
                        </div>
                    </x-link>
                </header>

                @if ($media = $article->getFirstMediaUrl('media'))
                    <div class="aspect-h-2 aspect-w-4 mx-auto mt-6 sm:mt-8">
                        <img
                            class="rounded-lg object-cover shadow-lg group-hover:opacity-75"
                            src="{{ $media }}"
                            alt="{{ $article->title }}"
                        />
                    </div>
                @endif

                <x-markdown-content
                    id="content"
                    class="prose prose-lg prose-green mx-auto mt-8 overflow-x-hidden text-gray-500 dark:text-gray-400 md:prose-xl lg:max-w-none"
                    :content="$article->body"
                />

                <div class="mt-6 border-t border-gray-200 pt-5 dark:border-white/20 sm:hidden">
                    <div class="space-y-4">
                        <x-link :href="route('profile', $user->username)" class="block shrink-0">
                            <div class="flex items-center">
                                <div>
                                    <img
                                        class="inline-block size-9 rounded-full"
                                        src="{{ $user->profile_photo_url }}"
                                        alt="{{ $user->username }}"
                                    />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ '@' . $user->username }}
                                    </p>
                                </div>
                            </div>
                        </x-link>
                        @if ($user->bio)
                            <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                                {{ $user->bio }}
                            </p>
                        @endif

                        <div class="flex space-x-3">
                            @if ($user->twitter())
                                <a
                                    href="https://twitter.com/{{ $user->twitter() }}"
                                    class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                >
                                    <span class="sr-only">Twitter</span>
                                    <x-icon.twitter class="size-6" />
                                </a>
                            @endif

                            @if ($user->linkedin())
                                <a
                                    href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                    class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                >
                                    <span class="sr-only">LinkedIn</span>
                                    <x-icon.linkedin class="size-6" />
                                </a>
                            @endif

                            @if ($user->githubUsername())
                                <a
                                    href="https://github.com/{{ $user->githubUsername() }}"
                                    class="text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                >
                                    <span class="sr-only">GitHub</span>
                                    <x-icon.github class="size-6" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="py-6">
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                        {{ __('pages/article.share_article') }}
                    </p>
                    <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-x-4 sm:space-y-0">
                        <a
                            href="https://twitter.com/share?text={{ urlencode('"' . $article->title . '" par ' . ($article->user->twitter() ? '@' . $article->user->twitter() : $article->user->name) . ' #caparledev - ') }}&url={{ urlencode(route('articles.show', $article)) }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.twitter class="size-5" aria-hidden="true" />
                            Twitter
                        </a>
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}&quote={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.facebook class="size-5" aria-hidden="true" />
                            Facebook
                        </a>
                        <a
                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article)) }}&title={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.linkedin class="size-5" aria-hidden="true" />
                            LinkedIn
                        </a>
                    </div>
                </div>

                @canany([App\Policies\ArticlePolicy::UPDATE, App\Policies\ArticlePolicy::DELETE], $article)
                    <div class="relative mt-10">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                <x-buttons.default
                                    link="{{ route('articles.edit', $article) }}"
                                    class="relative inline-flex items-center rounded-none rounded-l-lg border border-gray-300"
                                >
                                    <span class="sr-only">{{ __('actions.edit') }}</span>
                                    <x-untitledui-pencil class="size-5" aria-hidden="true" />
                                </x-buttons.default>

                                @if ($article->isNotApproved())
                                    @hasanyrole('admin|moderator')
                                        <x-buttons.default
                                            onclick="Livewire.dispatch('openModal', { component: 'modals.approved-article', arguments: {{ json_encode([$article->id]) }} })"
                                            type="button"
                                            class="relative -ml-px inline-flex items-center rounded-none border border-gray-200 text-green-500 focus:z-10 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                        >
                                            <span class="sr-only">{{ __('actions.approve') }}</span>
                                            <x-untitledui-check-verified-02 class="size-5" aria-hidden="true" />
                                        </x-buttons.default>
                                    @endhasanyrole
                                @endif

                                <x-buttons.default
                                    onclick="Livewire.dispatch('openModal', { component: 'modals.delete-article', arguments: {{ json_encode([$article->id]) }} })"
                                    type="button"
                                    class="relative inline-flex items-center rounded-none rounded-r-lg border border-gray-200"
                                >
                                    <span class="sr-only">{{ __('actions.delete') }}</span>
                                    <x-untitledui-trash-03 class="size-5" aria-hidden="true" />
                                </x-buttons.default>
                            </span>
                        </div>
                    </div>
                @endcanany

                @if ($next || $previous)
                    <footer class="border-skin-light mt-10 border-t lg:hidden">
                        <div class="space-y-8 py-8 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                            @if ($next)
                                <div>
                                    <h2 class="text-xs uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        Article suivant
                                    </h2>
                                    <div class="mt-3 flex items-start space-x-2">
                                        <img
                                            class="size-10 rounded-md object-cover shadow-lg"
                                            src="{{ $next->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                            alt="{{ $next->slug }}"
                                        />
                                        <div class="flex flex-col space-y-1">
                                            <a
                                                class="line-clamp-2 text-base font-medium leading-4 text-gray-900 hover:text-primary-600-hover"
                                                href="{{ route('articles.show', $next) }}"
                                            >
                                                {{ $next->title }}
                                            </a>
                                            <span class="text-sm text-skin-muted">
                                                {{ $next->readTime() }} min de lecture
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($previous)
                                <div>
                                    <h2 class="text-xs uppercase leading-5 tracking-wide text-gray-500 dark:text-gray-400">
                                        Article précédent
                                    </h2>
                                    <div class="mt-3 flex items-start space-x-2">
                                        <img
                                            class="size-10 rounded-md object-cover shadow-lg"
                                            src="{{ $previous->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                            alt="{{ $previous->slug }}"
                                        />
                                        <div class="flex flex-col space-y-1">
                                            <a
                                                class="line-clamp-2 text-base font-medium leading-4 text-gray-900 hover:text-primary-600-hover"
                                                href="{{ route('articles.show', $previous) }}"
                                            >
                                                {{ $previous->title }}
                                            </a>
                                            <span class="text-sm text-skin-muted">
                                                {{ $previous->readTime() }} min de lecture
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </footer>
                @endif
            </div>
            <div class="relative hidden lg:col-span-2 lg:block">
                <x-sticky-content class="space-y-10">
                    <x-sponsors />

                    @if ($article->showToc())
                        <div class="rounded-lg bg-skin-card px-4 py-6 shadow-lg">
                            <h4
                                class="text-sm font-semibold uppercase leading-tight tracking-widest text-gray-900"
                            >
                                Table des matières
                            </h4>
                            <x-toc class="toc mt-4" id="toc">{!! $article->body !!}</x-toc>
                        </div>
                    @endif

                    <x-ads />

                    <x-discord />
                </x-sticky-content>
            </div>
        </article>
    </x-container>

    @if ($article->showToc())
        <div x-data="{ openTOC: false }" class="relative lg:hidden">
            <button
                @click="openTOC =! openTOC"
                class="border-skin-light fixed right-0 top-40 z-30 -mr-1 mt-8 flex size-10 items-center justify-center rounded-l-lg border bg-skin-card px-1.5 py-1 text-gray-500 dark:text-gray-400 shadow hover:bg-skin-card-muted hover:text-gray-900 sm:mt-12 md:w-auto lg:hidden"
            >
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor" fill-rule="nonzero">
                        <circle cx="2.286" cy="2.286" r="2.286" />
                        <circle cx="2.286" cy="10.286" r="2.286" />
                        <circle cx="2.286" cy="18.286" r="2.286" />
                        <path
                            d="M9.143 4.571h12.571a2.286 2.286 0 000-4.571H9.143a2.286 2.286 0 000 4.571zM21.714 8H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 000-4.571zM21.714 16H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 100-4.571z"
                        />
                    </g>
                </svg>
                <span class="ml-1 hidden text-sm font-semibold uppercase md:block">Sommaire</span>
            </button>

            <div
                @keydown.window.escape="openTOC = false"
                x-show="openTOC"
                class="fixed inset-0 z-50 overflow-hidden"
                aria-labelledby="slide-over-title"
                x-ref="dialog"
                aria-modal="true"
            >
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0" @click="openTOC = false" aria-hidden="true">
                        <div class="fixed inset-y-0 right-0 mt-16 flex max-w-full pl-10">
                            <div
                                x-show="openTOC"
                                x-transition:enter="transform transition duration-500 ease-in-out sm:duration-700"
                                x-transition:enter-start="translate-x-full"
                                x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition duration-500 ease-in-out sm:duration-700"
                                x-transition:leave-start="translate-x-0"
                                x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-xs"
                            >
                                <div
                                    class="flex h-[450px] flex-col overflow-y-scroll rounded-l-lg bg-skin-card py-6 shadow-xl"
                                >
                                    <div class="px-4 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                                Table des Matières
                                            </h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button
                                                    type="button"
                                                    class="rounded-md bg-skin-card text-skin-muted hover:text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                    @click="openTOC = false"
                                                >
                                                    <span class="sr-only">Fermer</span>
                                                    <x-untitledui-x class="size-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                        <x-toc class="toc" id="toc">{!! $article->body !!}</x-toc>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
