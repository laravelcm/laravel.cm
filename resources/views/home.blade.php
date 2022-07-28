@extends('layouts.large')

@section('body')

    <x-container class="max-w-7xl mx-auto px-4">
        <div class="relative py-10 lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left lg:self-center">
                <a href="{{ route('discussions.index') }}" class="inline-flex items-center text-white bg-green-700 rounded-full p-1 pr-2 sm:text-base lg:text-sm xl:text-base font-sans">
                    <span class="hidden sm:block px-3 py-0.5 text-white text-xs font-semibold leading-5 uppercase tracking-wide bg-flag-green rounded-full">Discussions</span>
                    <span class="ml-4 text-sm">Nouvelle section disponible sur le site</span>
                    <x-heroicon-s-chevron-right class="ml-2 w-5 h-5 text-white" />
                </a>
                <h1 class="mt-4 text-4xl tracking-tight font-mono font-medium text-skin-primary sm:mt-5 sm:leading-none lg:mt-8 lg:text-5xl">
                    Laravel Cameroun
                </h1>
                <p class="mt-3 text-base text-skin-base sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                    Bienvenue sur le site de la communauté des développeurs PHP et Laravel du Cameroun, le plus gros rassemblement de développeurs au Cameroun.
                </p>
                <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                    <div class="mt-3 sm:flex">
                        @auth
                            <x-button :link="route('forum.new')" class="w-full sm:w-auto text-base font-normal">
                                Lancer un thread
                            </x-button>
                        @else
                            <x-button :link="route('login')" class="w-full sm:w-auto text-base font-normal">
                                Rejoindre la communauté
                            </x-button>
                        @endauth
                        <x-default-button :link="route('forum.index')" class="mt-3 w-full sm:mt-0 sm:ml-3 sm:shrink-0 sm:inline-flex sm:items-center sm:w-auto text-base font-normal">
                            Visiter le Forum
                        </x-default-button>
                    </div>
                </div>
            </div>
            <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                <img src="{{ asset('/images/illustration.svg') }}" alt="Illustration" />
            </div>
        </div>

        <div class="divide-y divide-skin-base">
            <div class="py-10 lg:py-12 xl:pb-14">
                <p class="text-center text-base uppercase tracking-tight text-skin-base tracking-wider leading-6 font-sans">
                    Nous travaillons avec d’autres communautés et startups
                </p>
                <div class="mt-8 grid grid-cols-2 gap-y-8 lg:grid-cols-3 lg:mt-12">
                    <div class="col-span-2 flex justify-center lg:col-span-1">
                        <a href="https://cosna-afrique.com" target="_blank" class="flex items-center">
                            <x-icon.cosna class="h-14 w-auto"/>
                        </a>
                    </div>
                    <div class="col-span-2 flex justify-center lg:col-span-1">
                        <a href="https://laravelshopper.io" target="_blank" class="flex items-center">
                            <img class="h-12 logo-white" src="{{ asset('/images/sponsors/shopper-logo.svg') }}" alt="Laravel Shopper">
                            <img class="h-12 logo-dark" src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}" alt="Laravel Shopper">
                        </a>
                    </div>
                    <div class="col-span-2 flex justify-center lg:col-span-1">
                        <a href="https://gdg.community.dev/gdg-douala" target="_blank" class="flex items-center">
                            <x-icon.gdg class="h-8 text-skin-inverted" />
                        </a>
                    </div>
                </div>
                <div class="mt-6 text-center lg:mt-10">
                    <a class="text-sm leading-5 text-flag-green hover:text-green-600 hover:underline" href="mailto:arthur@laravel.cm">Votre logo ici ?</a>
                </div>
            </div>

            <div class="py-12 lg:py-20">
                <x-section-header
                    title="Articles Populaires"
                    content="Découvrez les articles les plus appréciés et partagés par les membres de la communauté"
                />
                <div class="mt-8 grid gap-10 max-w-xl mx-auto lg:grid-rows-3 lg:grid-flow-col lg:grid-cols-2 lg:mt-10 lg:gap-x-8 lg:max-w-none">
                    @foreach($latestArticles as $article)
                        @if($loop->first)
                            <div class="lg:row-span-3">
                                <x-articles.card :article="$article" />
                            </div>
                        @else
                            <div class="lg:col-span-2">
                                <x-articles.summary :article="$article" />
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="flex items-center justify-center mt-10 sm:mt-12 xl:mt-16">
                    <x-button :link="route('articles')">
                        Voir tous les articles
                        <x-heroicon-o-arrow-narrow-right class="h-5 w-5 ml-1.5" />
                    </x-button>
                </div>
            </div>

            @if($latestThreads->isNotEmpty())
                <div class="py-12 lg:py-20">
                    <x-section-header
                        title="On apprend aussi en aidant les autres"
                        content="En rejoignant la communauté, vous pouvez consulter les dernières questions non résolues et apporter votre pierre à l’édifice."
                    />
                    <div class="mt-10 grid gap-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12 lg:mt-12">
                        @foreach($latestThreads as $thread)
                            <div>
                                <div class="flex items-center font-sans text-skin-base">
                                    <a href="{{ route('profile', $thread->author->username) }}" class="inline-flex items-center hover:underline">
                                        <img class="inline-block rounded-full h-6 w-6 mr-1.5" src="{{ $thread->author->profile_photo_url }}" alt="Avatar de {{ $thread->author->username }}">
                                        <span class="font-sans">{{ '@' . $thread->author->username }}</span>
                                    </a>
                                    <span class="inline-flex mx-1.5 space-x-1.5">
                                        <span>a posé</span>
                                        <time class="sr-only" datetime="{{ $thread->created_at }}" title="{{ $thread->last_posted_at->format('j M, Y \à H:i') }}">{{ $thread->last_posted_at->format('j M, Y \à H:i') }}</time>
                                        <time-ago time="{{ $thread->created_at->getTimestamp() }}"/>
                                    </span>
                                </div>
                                <a href="{{ route('forum.show', $thread) }}" class="mt-3 block">
                                    <p class="text-xl font-medium text-skin-inverted font-sans">
                                        {{ $thread->subject() }}
                                    </p>
                                    <p class="mt-3 text-base text-skin-base font-normal">
                                        {!! $thread->excerpt() !!}
                                    </p>
                                </a>
                                <div class="mt-3">
                                    <a href="{{ route('forum.show', $thread) }}" class="text-base font-medium text-green-600 hover:text-green-500 hover:underline font-normal">
                                        Afficher la question
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-center mt-10 sm:mt-12 xl:mt-16">
                        <x-button :link="route('forum.index')">
                            Voir tous les sujets
                            <x-heroicon-o-arrow-narrow-right class="h-5 w-5 ml-1.5" />
                        </x-button>
                    </div>
                </div>
            @endif

            <div class="py-12 lg:py-20">
                <x-section-header
                    title="Ou venez juste discuter"
                    content="Dans la communauté on partage aussi des sujets de discussions dans divers domaines, pour nous édifier tous ensemble. Rejoins nous en participant"
                />

                <div class="mt-8 grid gap-8 md:grid-cols-3 md:gap-x-10 lg:mt-12">
                    @foreach($latestDiscussions as $discussion)
                        <div>
                            <div class="flex items-center text-sm font-sans text-skin-muted">
                                <a class="shrink-0" href="/user/{{ $discussion->author->username }}">
                                    <img class="h-6 w-6 rounded-full" src="{{ $discussion->author->profile_photo_url }}" alt="{{ $discussion->author->name }}">
                                </a>
                                <span class="ml-2 pr-1">Posté par</span>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('profile', $discussion->author->username) }}" class="text-skin-inverted hover:underline">{{ $discussion->author->name }}</a>
                                    <span aria-hidden="true">&middot;</span>
                                    <time-ago time="{{ $discussion->created_at->getTimestamp() }}"/>
                                </div>
                            </div>
                            <a href="{{ route('discussions.show', $discussion) }}" class="mt-2 block">
                                <p class="text-xl font-semibold text-skin-inverted">{{ $discussion->title }}</p>
                                <p class="mt-3 text-base text-skin-base">{!! $discussion->excerpt() !!}</p>
                            </a>
                            <div class="mt-3">
                                <a href="{{ route('discussions.show', $discussion) }}" class="text-base font-medium text-flag-green hover:text-green-500"> Lire la discussion </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-center mt-10 sm:mt-12 xl:mt-16">
                    <x-button :link="route('discussions.index')">
                        Voir toutes les discussions
                        <x-heroicon-o-arrow-narrow-right class="h-5 w-5 ml-1.5" />
                    </x-button>
                </div>
            </div>
        </div>
    </x-container>

    <div class="relative bg-black">
        <div class="h-80 w-full absolute bottom-0 xl:inset-0 xl:h-full">
            <div class="h-full w-full xl:grid xl:grid-cols-2">
                <div class="h-full xl:relative xl:col-start-2">
                    <img class="h-full w-full object-cover opacity-25 xl:absolute xl:inset-0" src="{{ asset('/images/developer.png') }}" alt="Developer working on laptop">
                    <div aria-hidden="true" class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-black xl:inset-y-0 xl:left-0 xl:h-full xl:w-32 xl:bg-gradient-to-r"></div>
                </div>
            </div>
        </div>
        <div class="max-w-4xl mx-auto px-4 lg:max-w-7xl xl:grid xl:grid-cols-2 xl:grid-flow-col-dense xl:gap-x-8">
            <div class="relative pt-12 pb-64 sm:pt-24 sm:pb-64 xl:col-start-1 xl:pb-24">
                <h2 class="text-sm font-semibold text-green-300 tracking-wide uppercase font-mono">A propos</h2>
                <p class="mt-3 text-3xl font-extrabold text-white">Nous construisons une communauté Open Source d'apprenants et d'enseignants</p>
                <p class="mt-5 text-lg text-gray-400">
                    <span class="text-white"><span class="text-skin-primary italic">"</span>Tout le monde enseigne, tout le monde apprend<span class="text-skin-primary italic">"</span></span>.
                    Tel est l'esprit qui est derrière la communauté. Une communauté qui se veut grandissante et qui donne la possibilité à tout le monde de partager ses connaissances et d'apprendre.
                </p>
                <div class="mt-12 grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2">
                    <p>
                        <span class="block text-2xl font-mono text-white">600+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">Membres</span> qui ont rejoins les différents groupes de la communauté
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl font-mono text-white">50K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">Développeurs PHP & Laravel</span> dans l’ensemble du territoire national.
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl font-mono text-white">9%</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">Taux de participation aux événements</span> car la communauté est encore très jeune.
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl font-mono text-white">10K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">stars</span> sur les projets réalisés par les développeurs Camerounais sur Github.
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

@stop
