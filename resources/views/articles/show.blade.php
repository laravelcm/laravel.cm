@title($article->title)

@extends('layouts.default')

@section('body')

    <article class="relative lg:grid lg:grid-cols-9 lg:gap-10" xmlns:livewire="http://www.w3.org/1999/html">
        <div class="hidden lg:block lg:col-span-2">
            <div class="divide-y divide-skin-base sticky space-y-6 top-4">
                <div>
                    <h4 class="text-xs text-skin-base font-medium leading-4 tracking-wide uppercase font-sans">A propos de l’auteur</h4>
                    <div class="mt-6 space-y-4">
                        <a href="/user/{{ $article->author->username }}" class="flex-shrink-0 block">
                            <div class="flex items-center">
                                <div>
                                    <img class="inline-block h-9 w-9 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->username }}">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-skin-inverted font-sans">
                                        {{ $article->author->name }}
                                    </p>
                                    <p class="text-xs font-medium text-skin-muted font-sans">
                                        {{ '@' . $article->author->username }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @if($article->author->bio)
                            <p class="text-sm text-skin-base leading-5 font-normal">{{ $article->author->bio }}</p>
                        @endif
                        <div class="flex space-x-3">

                            @if($article->author->twitter())
                                <a href="https://twitter.com/{{ $article->author->twitter() }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                    </svg>
                                </a>
                            @endif

                            @if ($article->author->githubUsername())
                                <a href="https://github.com/{{ $article->author->githubUsername() }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">GitHub</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                @if($article->nextArticle() || $article->previousArticle())
                    <div class="pt-6 space-y-6">
                        @if($next = $article->nextArticle())
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">Article suivant</h2>
                                <a href="{{ route('articles.show', $next) }}" class="mt-3 flex items-start space-x-2">
                                    <img class="h-8 w-8 object-cover shadow-lg rounded-md" src="{{ $next->getFirstMediaUrl('media') }}" alt="{{ $next->slug }}">
                                    <span class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2">{{ $next->title }}</span>
                                </a>
                            </div>
                        @endif

                        @if($previous = $article->previousArticle())
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">Article précédent</h2>
                                <a href="{{ route('articles.show', $previous) }}" class="mt-3 flex items-start space-x-2">
                                    <img class="h-8 w-8 object-cover shadow-lg rounded-md" src="{{ $previous->getFirstMediaUrl('media') }}" alt="{{ $previous->slug }}">
                                    <span class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2">{{ $previous->title }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="pt-6">
                    <livewire:reactions :model="$article" />
                </div>
            </div>
        </div>
        <div class="lg:col-span-5">
            <header class="space-y-4">
                <div class="sm:flex sm:items-center sm:flex-row sm:justify-between">
                    @if ($article->tags->isNotEmpty())
                        <div class="flex items-center space-x-2">
                            @foreach ($article->tags as $tag)
                                <x-tag :tag="$tag" />
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-2 flex space-x-1 text-sm text-skin-base sm:mt-0">
                        <time datetime="{{ $article->createdAt()->format('Y-m-d') }}">{{ $article->createdAt()->format('j M, Y') }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ $article->readTime() }} min de lecture</span>
                    </div>
                </div>
                <h1 class="text-2xl font-extrabold text-skin-inverted tracking-tight font-sans sm:text-3xl sm:leading-10 md:text-4xl lg:text-5xl lg:leading-[3.5rem]">{{ $article->title }}</h1>
                <a href="/user/{{ $article->author->username }}" class="mt-3 flex-shrink-0 group block lg:hidden">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block h-8 w-8 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->username }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-skin-base">
                                {{ $article->author->name }}
                            </p>
                            <p class="text-xs font-medium text-green-500 group-hover:text-skin-primary">
                                {{ '@' . $article->author->username }}
                            </p>
                        </div>
                    </div>
                </a>
            </header>
            <div class="mt-6 aspect-w-4 aspect-h-2 sm:mt-8 mx-auto">
                <img class="object-cover shadow-lg rounded-lg group-hover:opacity-75" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
            </div>
            <div
                class="mt-8 prose prose-lg prose-green text-skin-base mx-auto md:prose-xl lg:max-w-none"
            >
                <x-markdown-content :content="$article->body" />
            </div>

            @if(auth()->check() && auth()->id() === $article->user_id)

                <div class="relative mt-10">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-skin-base"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="relative z-0 inline-flex shadow-sm rounded-md -space-x-px">
                            <a href="{{ route('articles.edit', $article) }}" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-skin-base bg-skin-card text-sm font-medium text-gray-400 hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                <span class="sr-only">Éditer</span>
                                <x-heroicon-s-pencil class="h-5 w-5" />
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-skin-base bg-skin-card text-sm font-medium text-gray-400 hover:bg-skin-card-muted focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 focus:ring-offset-body">
                                <span class="sr-only">Supprimer</span>
                                <x-heroicon-s-trash class="h-5 w-5" />
                            </a>
                        </span>
                    </div>
                </div>

            @endif

            @if($article->nextArticle() || $article->previousArticle())
                <footer class="mt-10 border-t border-skin-light lg:hidden">
                    <div class="space-y-8 py-8 sm:flex sm:items-center sm:space-y-0">
                        @if($next = $article->nextArticle())
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">Article suivant</h2>
                                <div class="mt-3 flex items-start space-x-2">
                                    <img class="h-10 w-10 object-cover shadow-lg rounded-md" src="{{ $next->cover_image_url }}" alt="{{ $next->slug }}">
                                    <div class="flex flex-col space-y-1">
                                        <a class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2" href="{{ route('articles.show', $next) }}">{{ $next->title }}</a>
                                        <span class="text-sm text-skin-muted">{{ $next->readTime() }} min de lecture</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($previous = $article->previousArticle())
                            <div>
                                <h2 class="text-xs leading-5 tracking-wide uppercase text-skin-base">Article précédent</h2>
                                <div class="mt-3 flex items-start space-x-2">
                                    <img class="h-10 w-10 object-cover shadow-lg rounded-md" src="{{ $previous->cover_image_url }}" alt="{{ $previous->slug }}">
                                    <div class="flex flex-col space-y-1">
                                        <a class="text-sm font-medium leading-4 text-skin-inverted hover:text-skin-primary-hover line-clamp-2" href="{{ route('articles.show', $previous) }}">{{ $previous->title }}</a>
                                        <span class="text-sm text-skin-muted">{{ $previous->readTime() }} min de lecture</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </footer>
            @endif
        </div>
        <div class="hidden lg:block lg:col-span-2">
            <div class="sticky top-4 space-y-10">
                @if($article->showToc())
                    <div class="bg-skin-card px-4 py-6 rounded-lg shadow-lg">
                        <h4 class="text-sm text-skin-inverted font-semibold leading-tight tracking-widest uppercase">Table des matières</h4>
                        <x-toc class="mt-4 toc" id="toc">{!! $article->body !!}</x-toc>
                    </div>
                @endif

                <x-ads />
            </div>
        </div>
    </article>

    @if($article->showToc())
        <div x-data="{ openTOC: false }" class="relative lg:hidden">
            <button
                @click="openTOC =! openTOC"
                class="fixed z-30 right-0 top-40 flex items-center justify-center block px-1.5 py-1 h-10 w-10 mt-8 -mr-1 text-skin-base border border-skin-light rounded-l-lg shadow hover:text-skin-inverted sm:mt-12 lg:hidden bg-skin-card hover:bg-skin-card-muted md:w-auto">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor" fill-rule="nonzero">
                        <circle cx="2.286" cy="2.286" r="2.286" />
                        <circle cx="2.286" cy="10.286" r="2.286" />
                        <circle cx="2.286" cy="18.286" r="2.286" />
                        <path d="M9.143 4.571h12.571a2.286 2.286 0 000-4.571H9.143a2.286 2.286 0 000 4.571zM21.714 8H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 000-4.571zM21.714 16H9.143a2.286 2.286 0 000 4.571h12.571a2.286 2.286 0 100-4.571z" />
                    </g>
                </svg>
                <span class="hidden ml-1 text-sm font-semibold uppercase md:block">Sommaire</span>
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
                        <div class="fixed inset-y-0 right-0 pl-10 mt-16 max-w-full flex">
                            <div x-show="openTOC"
                                 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                 x-transition:enter-start="translate-x-full"
                                 x-transition:enter-end="translate-x-0"
                                 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                 x-transition:leave-start="translate-x-0"
                                 x-transition:leave-end="translate-x-full"
                                 class="w-screen max-w-xs"
                            >
                                <div class="h-[450px] flex flex-col py-6 bg-skin-card shadow-xl rounded-l-lg overflow-y-scroll">
                                    <div class="px-4 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <h2 class="text-lg font-medium text-skin-inverted" id="slide-over-title">
                                                Table des Matières
                                            </h2>
                                            <div class="ml-3 h-7 flex items-center">
                                                <button type="button" class="bg-skin-card rounded-md text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" @click="openTOC = false">
                                                    <span class="sr-only">Fermer</span>
                                                    <x-heroicon-o-x class="h-6 w-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 relative flex-1 px-4 sm:px-6">
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
