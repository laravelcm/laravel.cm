<x-app-layout :title="$article->title">
    @php
        $next = $article->nextArticle();
        $previous = $article->previousArticle();
        $user = $article->user;
    @endphp

    <x-container class="py-12">
        <article class="relative lg:grid lg:grid-cols-9 lg:gap-10" xmlns:livewire="http://www.w3.org/1999/html">
            <div class="relative hidden lg:col-span-2 lg:block">
                <x-sticky-content class="space-y-6 divide-y divide-skin-base">
                    <div>
                        <h4 class="font-heading text-xs font-medium uppercase leading-4 tracking-wide text-skin-base">
                            À propos de l’auteur
                        </h4>
                        <div class="mt-6 space-y-4">
                            <a href="{{ route('profile', $user->username) }}" class="block shrink-0">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                        <x-user.avatar :user="$user" class="h-9 w-9" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-skin-inverted">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-xs font-medium text-skin-muted">
                                            {{ '@' . $user->username }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @if ($user->bio)
                                <p class="text-sm leading-5 text-skin-base">{{ $user->bio }}</p>
                            @endif

                            <div class="flex space-x-3">
                                @if ($user->twitter())
                                    <a
                                        href="https://twitter.com/{{ $user->twitter() }}"
                                        class="text-skin-muted hover:text-skin-base"
                                    >
                                        <span class="sr-only">Twitter</span>
                                        <x-icon.twitter class="h-6 w-6" />
                                    </a>
                                @endif

                                @if ($user->linkedin())
                                    <a
                                        href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                        class="text-skin-muted hover:text-skin-base"
                                    >
                                        <span class="sr-only">LinkedIn</span>
                                        <x-icon.linkedin class="h-6 w-6" />
                                    </a>
                                @endif

                                @if ($user->githubUsername())
                                    <a
                                        href="https://github.com/{{ $user->githubUsername() }}"
                                        class="text-skin-muted hover:text-skin-base"
                                    >
                                        <span class="sr-only">GitHub</span>
                                        <x-icon.github class="h-6 w-6" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($next || $previous)
                        <div class="space-y-6 pt-6">
                            @if ($next)
                                <div>
                                    <h2 class="text-xs font-medium uppercase leading-5 tracking-wide text-skin-base">
                                        Article suivant
                                    </h2>
                                    <a
                                        href="{{ route('articles.show', $next) }}"
                                        class="mt-3 flex items-start space-x-2"
                                    >
                                        <img
                                            class="h-8 w-8 rounded-md object-cover shadow-lg"
                                            src="{{ $next->getFirstMediaUrl('media') }}"
                                            alt="{{ $next->slug }}"
                                        />
                                        <span
                                            class="line-clamp-2 text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover"
                                        >
                                            {{ $next->title }}
                                        </span>
                                    </a>
                                </div>
                            @endif

                            @if ($previous)
                                <div>
                                    <h2 class="text-xs font-medium uppercase leading-5 tracking-wide text-skin-base">
                                        Article précédent
                                    </h2>
                                    <a
                                        href="{{ route('articles.show', $previous) }}"
                                        class="mt-3 flex items-start space-x-2"
                                    >
                                        <img
                                            class="h-8 w-8 rounded-md object-cover shadow-lg"
                                            src="{{ $previous->getFirstMediaUrl('media') }}"
                                            alt="{{ $previous->slug }}"
                                        />
                                        <span
                                            class="line-clamp-2 text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover"
                                        >
                                            {{ $previous->title }}
                                        </span>
                                    </a>
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

                        <div class="mt-2 flex space-x-1 text-sm text-skin-base sm:mt-0">
                            <time class="capitalize" datetime="{{ $article->publishedAt()->format('Y-m-d') }}">
                                {{ $article->publishedAt()->isoFormat('LL') }}
                            </time>
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ $article->readTime() }} min de lecture</span>
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ $article->views_count }} vues</span>
                        </div>
                    </div>
                    <h1
                        class="font-heading text-2xl font-extrabold tracking-tight text-skin-inverted sm:text-3xl sm:leading-10 md:text-4xl lg:text-5xl lg:leading-[3.5rem]"
                    >
                        {{ $article->title }}
                    </h1>
                    <a
                        href="{{ route('profile', $article->user->username) }}"
                        class="group mt-3 block shrink-0 lg:hidden"
                    >
                        <div class="flex items-center">
                            <div>
                                <img
                                    class="inline-block h-8 w-8 rounded-full"
                                    src="{{ $article->user->profile_photo_url }}"
                                    alt="{{ $article->user->username }}"
                                />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-skin-inverted">
                                    {{ $article->user->name }}
                                </p>
                                <p class="text-xs text-skin-muted">
                                    {{ '@' . $article->user->username }}
                                </p>
                            </div>
                        </div>
                    </a>
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
                    class="prose prose-lg prose-green mx-auto mt-8 overflow-x-hidden text-skin-base md:prose-xl lg:max-w-none"
                    :content="$article->body"
                />

                <div class="mt-6 border-t border-skin-base pt-5 sm:hidden">
                    <div class="space-y-4">
                        <a href="{{ route('profile', $user->username) }}" class="block shrink-0">
                            <div class="flex items-center">
                                <div>
                                    <img
                                        class="inline-block h-9 w-9 rounded-full"
                                        src="{{ $user->profile_photo_url }}"
                                        alt="{{ $user->username }}"
                                    />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-skin-inverted">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-xs font-medium text-skin-muted">
                                        {{ '@' . $user->username }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @if ($user->bio)
                            <p class="text-sm leading-5 text-skin-base">
                                {{ $user->bio }}
                            </p>
                        @endif

                        <div class="flex space-x-3">
                            @if ($user->twitter())
                                <a
                                    href="https://twitter.com/{{ $user->twitter() }}"
                                    class="text-skin-muted hover:text-skin-base"
                                >
                                    <span class="sr-only">Twitter</span>
                                    <x-icon.twitter class="h-6 w-6" />
                                </a>
                            @endif

                            @if ($user->linkedin())
                                <a
                                    href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                    class="text-skin-muted hover:text-skin-base"
                                >
                                    <span class="sr-only">LinkedIn</span>
                                    <x-icon.linkedin class="h-6 w-6" />
                                </a>
                            @endif

                            @if ($user->githubUsername())
                                <a
                                    href="https://github.com/{{ $user->githubUsername() }}"
                                    class="text-skin-muted hover:text-skin-base"
                                >
                                    <span class="sr-only">GitHub</span>
                                    <x-icon.github class="h-6 w-6" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="py-6">
                    <p class="text-base font-normal text-skin-base">
                        Vous aimez cet article ? Faite le savoir en partageant
                    </p>
                    <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-x-4 sm:space-y-0">
                        <a
                            href="https://twitter.com/share?text={{ urlencode('"' . $article->title . '" par ' . ($article->user->twitter() ? '@' . $article->user->twitter() : $article->user->name) . ' #caparledev - ') }}&url={{ urlencode(route('articles.show', $article)) }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-skin-base shadow-sm hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.twitter class="mr-1.5 h-5 w-5" />
                            Twitter
                        </a>
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}&quote={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-skin-base shadow-sm hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.facebook class="mr-1.5 h-5 w-5" />
                            Facebook
                        </a>
                        <a
                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article)) }}&title={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                            class="inline-flex items-center rounded-md border border-skin-base bg-skin-button px-4 py-2 text-sm font-normal leading-5 text-skin-base shadow-sm hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                        >
                            <x-icon.linkedin class="mr-1.5 h-5 w-5" />
                            LinkedIn
                        </a>
                    </div>
                </div>

                @canany([App\Policies\ArticlePolicy::UPDATE, App\Policies\ArticlePolicy::DELETE], $article)
                    <div class="relative mt-10">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-skin-base"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                <a
                                    href="{{ route('articles.edit', $article) }}"
                                    class="relative inline-flex items-center rounded-l-md border border-skin-base bg-skin-card px-4 py-2 text-sm font-medium text-skin-inverted-muted hover:bg-skin-card-muted focus:z-10 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500 focus:ring-offset-body"
                                >
                                    <span class="sr-only">Éditer</span>
                                    <x-heroicon-s-pencil class="h-5 w-5" />
                                </a>
                                @if ($article->isNotApproved())
                                    @hasanyrole('admin|moderator')
                                        <button
                                            onclick="Livewire.dispatch('openModal', {component: 'modals.approved-article', arguments: {{ json_encode([$article->id]) }} })"
                                            type="button"
                                            class="relative -ml-px inline-flex items-center border border-skin-base bg-skin-card px-4 py-2 text-sm font-medium text-green-500 hover:bg-skin-card-muted focus:z-10 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500 focus:ring-offset-body"
                                        >
                                            <span class="sr-only">Approuver</span>
                                            <x-untitledui-check-verified-02 class="h-5 w-5" />
                                        </button>
                                    @endhasanyrole
                                @endif

                                <button
                                    onclick="Livewire.dispatch('openModal', {component: 'modals.delete-article', arguments: {{ json_encode([$article->id]) }} })"
                                    type="button"
                                    class="relative inline-flex items-center rounded-r-md border border-skin-base bg-skin-card px-4 py-2 text-sm font-medium text-skin-inverted-muted hover:bg-skin-card-muted focus:z-10 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500 focus:ring-offset-body"
                                >
                                    <span class="sr-only">Supprimer</span>
                                    <x-untitledui-trash-03 class="h-5 w-5" />
                                </button>
                            </span>
                        </div>
                    </div>
                @endcanany

                @if ($next || $previous)
                    <footer class="border-skin-light mt-10 border-t lg:hidden">
                        <div class="space-y-8 py-8 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                            @if ($next)
                                <div>
                                    <h2 class="text-xs uppercase leading-5 tracking-wide text-skin-base">
                                        Article suivant
                                    </h2>
                                    <div class="mt-3 flex items-start space-x-2">
                                        <img
                                            class="h-10 w-10 rounded-md object-cover shadow-lg"
                                            src="{{ $next->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                            alt="{{ $next->slug }}"
                                        />
                                        <div class="flex flex-col space-y-1">
                                            <a
                                                class="line-clamp-2 text-base font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover"
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
                                    <h2 class="text-xs uppercase leading-5 tracking-wide text-skin-base">
                                        Article précédent
                                    </h2>
                                    <div class="mt-3 flex items-start space-x-2">
                                        <img
                                            class="h-10 w-10 rounded-md object-cover shadow-lg"
                                            src="{{ $previous->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                            alt="{{ $previous->slug }}"
                                        />
                                        <div class="flex flex-col space-y-1">
                                            <a
                                                class="line-clamp-2 text-base font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover"
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
                                class="text-sm font-semibold uppercase leading-tight tracking-widest text-skin-inverted"
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
                class="border-skin-light fixed right-0 top-40 z-30 -mr-1 mt-8 flex h-10 w-10 items-center justify-center rounded-l-lg border bg-skin-card px-1.5 py-1 text-skin-base shadow hover:bg-skin-card-muted hover:text-skin-inverted sm:mt-12 md:w-auto lg:hidden"
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
                                            <h2 class="text-lg font-medium text-skin-inverted" id="slide-over-title">
                                                Table des Matières
                                            </h2>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button
                                                    type="button"
                                                    class="rounded-md bg-skin-card text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                                    @click="openTOC = false"
                                                >
                                                    <span class="sr-only">Fermer</span>
                                                    <x-untitledui-x class="h-6 w-6" />
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
