@title($article->title)

@extends('layouts.default')

@section('body')

    @php
        $next = $article->nextArticle();
        $previous = $article->previousArticle();
        $user = $article->user;
    @endphp

    <article class="relative lg:grid lg:grid-cols-9 lg:gap-10" xmlns:livewire="http://www.w3.org/1999/html">
        <div class="relative hidden lg:block lg:col-span-2">
            <x-sticky-content class="space-y-6 divide-y divide-skin-base">
                <div>
                    <h4 class="text-xs font-medium leading-4 tracking-wide uppercase text-skin-base font-heading">
                        {{ __('A propos de l’auteur') }}
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
                                <a href="https://twitter.com/{{ $user->twitter() }}"
                                    class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">Twitter</span>
                                    <x-icon.twitter class="w-6 h-6" />
                                </a>
                            @endif

                            @if ($user->linkedin())
                                <a href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                    class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">LinkedIn</span>
                                    <x-icon.linkedin class="w-6 h-6" />
                                </a>
                            @endif

                            @if ($user->githubUsername())
                                <a href="https://github.com/{{ $user->githubUsername() }}"
                                    class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">GitHub</span>
                                    <x-icon.github class="w-6 h-6" />
                                </a>
                            @endif

                        </div>
                    </div>
                </div>

                @if ($next || $previous)
                    <div class="pt-6 space-y-6">
                        @if ($next)
                            <div>
                                <h2 class="text-xs font-medium leading-5 tracking-wide uppercase text-skin-base">Article
                                    suivant</h2>
                                <a href="{{ route('articles.show', $next) }}" class="flex items-start mt-3 space-x-2">
                                    <img class="object-cover w-8 h-8 rounded-md shadow-lg"
                                        src="{{ $next->getFirstMediaUrl('media') }}" alt="{{ $next->slug }}">
                                    <span
                                        class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2">{{ $next->title }}</span>
                                </a>
                            </div>
                        @endif

                        @if ($previous)
                            <div>
                                <h2 class="text-xs font-medium leading-5 tracking-wide uppercase text-skin-base">Article
                                    précédent</h2>
                                <a href="{{ route('articles.show', $previous) }}" class="flex items-start mt-3 space-x-2">
                                    <img class="object-cover w-8 h-8 rounded-md shadow-lg"
                                        src="{{ $previous->getFirstMediaUrl('media') }}" alt="{{ $previous->slug }}">
                                    <span
                                        class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2">{{ $previous->title }}</span>
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
                <div class="sm:flex sm:items-center sm:flex-row sm:justify-between">
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

                    <div class="flex mt-2 space-x-1 text-sm text-skin-base sm:mt-0">
                        <time class="capitalize"
                            datetime="{{ $article->publishedAt()->format('Y-m-d') }}">{{ $article->publishedAt()->isoFormat('LL') }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ __(':time min de lecture', ['time' => $article->readTime()]) }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ __(':views vues', ['views' => $article->views_count]) }}</span>
                    </div>
                </div>
                <h1
                    class="text-2xl font-extrabold text-skin-inverted tracking-tight font-heading sm:text-3xl sm:leading-10 md:text-4xl lg:text-5xl lg:leading-[3.5rem]">
                    {{ $article->title }}
                </h1>
                <a href="{{ route('profile', $article->user->username) }}" class="block mt-3 shrink-0 group lg:hidden">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block w-8 h-8 rounded-full" src="{{ $article->user->profile_photo_url }}"
                                alt="{{ $article->user->username }}">
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
                <div class="mx-auto mt-6 aspect-w-4 aspect-h-2 sm:mt-8">
                    <img class="object-cover rounded-lg shadow-lg group-hover:opacity-75" src="{{ $media }}"
                        alt="{{ $article->title }}" />
                </div>
            @endif

            <x-markdown-content id="content"
                class="mx-auto mt-8 overflow-x-hidden prose prose-lg prose-green text-skin-base md:prose-xl lg:max-w-none"
                :content="$article->body" />

            <div class="pt-5 mt-6 border-t border-skin-base sm:hidden">
                <div class="space-y-4">
                    <a href="{{ route('profile', $user->username) }}" class="block shrink-0">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block rounded-full h-9 w-9" src="{{ $user->profile_photo_url }}"
                                    alt="{{ $user->username }}">
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
                            <a href="https://twitter.com/{{ $user->twitter() }}"
                                class="text-skin-muted hover:text-skin-base">
                                <span class="sr-only">{{ __('Twitter') }}</span>
                                <x-icon.twitter class="w-6 h-6" />
                            </a>
                        @endif

                        @if ($user->linkedin())
                            <a href="https://linkedin.com/in/{{ $user->linkedin() }}"
                                class="text-skin-muted hover:text-skin-base">
                                <span class="sr-only">{{ __('LinkedIn') }}</span>
                                <x-icon.linkedin class="w-6 h-6" />
                            </a>
                        @endif

                        @if ($user->githubUsername())
                            <a href="https://github.com/{{ $user->githubUsername() }}"
                                class="text-skin-muted hover:text-skin-base">
                                <span class="sr-only">{{ __('GitHub') }}</span>
                                <x-icon.github class="w-6 h-6" />
                            </a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="py-6">
                <p class="text-base font-normal text-skin-base">
                    {{ __('Vous aimez cet article ? Faite le savoir en partageant') }}
                </p>
                <div class="mt-4 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                    <a href="https://twitter.com/share?text={{ urlencode('"' . $article->title . '" par ' . ($article->user->twitter() ? '@' . $article->user->twitter() : $article->user->name) . ' #caparledev - ') }}&url={{ urlencode(route('articles.show', $article)) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-normal leading-5 border rounded-md shadow-sm border-skin-base bg-skin-button text-skin-base hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500">
                        <x-icon.twitter class="h-5 w-5 mr-1.5" />
                        {{ __('Twitter') }}
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articles.show', $article)) }}&quote={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-normal leading-5 border rounded-md shadow-sm border-skin-base bg-skin-button text-skin-base hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500">
                        <x-icon.facebook class="h-5 w-5 mr-1.5" />
                        {{ __('Facebook') }}
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article)) }}&title={{ urlencode('"' . $article->title . '" par ' . $article->user->name . ' - ') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-normal leading-5 border rounded-md shadow-sm border-skin-base bg-skin-button text-skin-base hover:bg-skin-button-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500">
                        <x-icon.linkedin class="h-5 w-5 mr-1.5" />
                        {{ __('LinkedIn') }}
                    </a>
                </div>
            </div>

            @canany([App\Policies\ArticlePolicy::UPDATE, App\Policies\ArticlePolicy::DELETE,
                App\Policies\ArticlePolicy::DISAPPROVE], $article)
                <div class="relative mt-10">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-skin-base"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                            <a href="{{ route('articles.edit', $article) }}"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium border rounded-l-md border-skin-base bg-skin-card text-skin-inverted-muted hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                <span class="sr-only">{{ __('Éditer') }}</span>
                                <x-heroicon-s-pencil class="w-5 h-5" />
                            </a>
                            @if ($article->isNotApproved())
                                @hasanyrole('admin|moderator')
                                    <button
                                        onclick="Livewire.emit('openModal', 'modals.approved-article', {{ json_encode([$article->id]) }})"
                                        type="button"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-green-500 border border-skin-base bg-skin-card hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                        <span class="sr-only">{{ __('Approuver') }}</span>
                                        <x-untitledui-check-verified-02 class="w-5 h-5" />
                                    </button>
                                @endhasanyrole
                            @endif
                            <button
                                onclick="Livewire.emit('openModal', 'modals.delete-article', {{ json_encode([$article->id]) }})"
                                type="button"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium border rounded-r-md border-skin-base bg-skin-card text-skin-inverted-muted hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                <span class="sr-only">{{ __('Supprimer') }}</span>
                                <x-untitledui-trash-03 class="w-5 h-5" />
                            </button>
                            @if ($article->isNotDeclined() && $article->isNotApproved())
                                @hasanyrole('admin|moderator')
                                    <button
                                        onclick="Livewire.emit('openModal', 'modals.declined-article', {{ json_encode([$article->id]) }})"
                                        type="button"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium border text-danger-500 border-skin-base bg-skin-card hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                        <span class="sr-only">{{ __('Decliner') }}</span>
                                        <x-untitledui-check-circle class="w-5 h-5" />
                                    </button>
                                @endhasanyrole
                            @endif
                        </span>
                    </div>
                </div>
            @endcanany

            @if ($next || $previous)
                <footer class="mt-10 border-t border-skin-light lg:hidden">
                    <div class="py-8 space-y-8 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                        @if ($next)
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">
                                    {{ __('Article suivant') }}</h2>
                                <div class="flex items-start mt-3 space-x-2">
                                    <img class="object-cover w-10 h-10 rounded-md shadow-lg"
                                        src="{{ $next->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                        alt="{{ $next->slug }}">
                                    <div class="flex flex-col space-y-1">
                                        <a class="text-base font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2"
                                            href="{{ route('articles.show', $next) }}">{{ $next->title }}</a>
                                        <span
                                            class="text-sm text-skin-muted">{{ __(':time min de lecture', ['time' => $next->readTime()]) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($previous)
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">
                                    {{ __('Article précédent') }}</h2>
                                <div class="flex items-start mt-3 space-x-2">
                                    <img class="object-cover w-10 h-10 rounded-md shadow-lg"
                                        src="{{ $previous->getFirstMediaUrl('media') ?? asset('images/socialcard.png') }}"
                                        alt="{{ $previous->slug }}">
                                    <div class="flex flex-col space-y-1">
                                        <a class="text-base font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2"
                                            href="{{ route('articles.show', $previous) }}">{{ $previous->title }}</a>
                                        <span
                                            class="text-sm text-skin-muted">{{ __(':time min de lecture', ['time' => $previous->readTime()]) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </footer>
            @endif
        </div>
        <div class="relative hidden lg:block lg:col-span-2">
            <x-sticky-content class="space-y-10">
                <x-sponsors />

                @if ($article->showToc())
                    <div class="px-4 py-6 rounded-lg shadow-lg bg-skin-card">
                        <h4 class="text-sm font-semibold leading-tight tracking-widest uppercase text-skin-inverted">
                            {{ __('Table des matières') }}</h4>
                        <x-toc class="mt-4 toc" id="toc">{!! $article->body !!}</x-toc>
                    </div>
                @endif

                <x-ads />

                <x-discord />
            </x-sticky-content>
        </div>
    </article>

    @if ($article->showToc())
        <div x-data="{ openTOC: false }" class="relative lg:hidden">
            <button @click="openTOC =! openTOC"
                class="fixed z-30 right-0 top-40 flex items-center justify-center block px-1.5 py-1 h-10 w-10 mt-8 -mr-1 text-skin-base border border-skin-light rounded-l-lg shadow hover:text-skin-inverted sm:mt-12 lg:hidden bg-skin-card hover:bg-skin-card-muted md:w-auto">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor" fill-rule="nonzero">
                        <circle cx="2.286" cy="2.286" r="2.286" />
                        <circle cx="2.286" cy="10.286" r="2.286" />
                        <circle cx="2.286" cy="18.286" r="2.286" />
                        <path
                            d="M9.143 4.571h12.571a2.286 2.286 0 000-4.571H9.143a2.286 2.286 0 000 4.571zM21.714 8H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 000-4.571zM21.714 16H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 100-4.571z" />
                    </g>
                </svg>
                <span class="hidden ml-1 text-sm font-semibold uppercase md:block">{{ __('Sommaire') }}</span>
            </button>

            <div @keydown.window.escape="openTOC = false" x-show="openTOC" class="fixed inset-0 z-50 overflow-hidden"
                aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0" @click="openTOC = false" aria-hidden="true">
                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 mt-16">
                            <div x-show="openTOC"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-xs">
                                <div
                                    class="h-[450px] flex flex-col py-6 bg-skin-card shadow-xl rounded-l-lg overflow-y-scroll">
                                    <div class="px-4 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <h2 class="text-lg font-medium text-skin-inverted" id="slide-over-title">
                                                {{ __('Table des Matières') }}</h2>
                                            <div class="flex items-center ml-3 h-7">
                                                <button type="button"
                                                    class="rounded-md bg-skin-card text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                    @click="openTOC = false">
                                                    <span class="sr-only">{{ __('Fermer') }}</span>
                                                    <x-untitledui-x class="w-6 h-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 px-4 mt-6 sm:px-6">
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

@endsection
