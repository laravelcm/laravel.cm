@extends('layouts.large')

@section('body')

    <div class="isolate -mt-16 pt-14">
        <div class="absolute inset-0 -z-10 mx-0 max-w-none overflow-hidden">
            <div class="absolute left-1/2 top-0 ml-[-32rem] h-[32rem] w-[84.25rem]">
                <div class="absolute inset-0 bg-gradient-to-r from-flag-red to-flag-yellow opacity-40 [mask-image:radial-gradient(farthest-side_at_top,white,transparent)]"></div>
                <svg viewBox="0 0 1113 440" aria-hidden="true" class="absolute left-1/2 top-0 ml-[-24rem] w-[70.5625rem] fill-green-500 blur-2xl opacity-30 logo-dark">
                    <path d="M.016 439.5s-9.5-300 434-300S882.516 20 882.516 20V0h230.004v439.5H.016Z"/>
                </svg>
                <svg viewBox="0 0 1113 440" aria-hidden="true" class="absolute left-1/2 top-0 ml-[-24rem] w-[70.5625rem] fill-yellow-50 blur-2xl opacity-50 logo-white">
                    <path d="M.016 439.5s-9.5-300 434-300S882.516 20 882.516 20V0h230.004v439.5H.016Z"/>
                </svg>
            </div>
        </div>
        <div class="mx-auto max-w-3xl px-4 pb-16 pt-28 sm:pt-32 lg:pt-40">
            <div class="flex justify-center">
                <a href="{{ route('sponsors') }}" class="inline-flex items-center p-1 pr-2 font-sans text-white bg-green-700 rounded-full sm:text-base lg:text-sm xl:text-base">
                    <span class="px-3 py-0.5 text-white text-xs font-semibold leading-5 uppercase tracking-wide bg-flag-green rounded-full">
                        ⚡️ {{ __('Sponsor') }}
                    </span>
                    <span class="ml-4 hidden text-sm sm:block">{{ __('Soutenez Laravel Cameroun aujourd\'hui en sponsorisant') }}</span>
                    <span class="ml-4 text-sm sm:hidden">{{ __('Soutenez Laravel Cameroun') }}</span>
                    <x-heroicon-s-chevron-right class="w-5 h-5 ml-2 text-white" />
                </a>
            </div>
            <div class="mt-10 text-center">
                <h1 class="text-4xl font-medium tracking-tight font-heading text-skin-primary sm:leading-none lg:text-6xl">
                    {{ __('Laravel Cameroun') }}
                </h1>
                <p class="mt-3 text-base text-skin-inverted sm:mt-5 sm:text-lg lg:text-xl">
                    {{ __('Bienvenue sur le site de la communauté des développeurs PHP et Laravel du Cameroun, le plus gros rassemblement de développeurs au Cameroun.') }}
                </p>
                <div class="mt-10 sm:flex sm:items-center sm:justify-center gap-x-6">
                    @auth
                        <x-button :link="route('forum.new')" class="w-full text-base font-medium sm:w-auto">
                            {{ __('Lancer un thread') }}
                        </x-button>
                    @else
                        <x-button :link="route('login')" class="w-full text-base font-medium sm:w-auto">
                            {{ __('Rejoindre la communauté') }}
                        </x-button>
                    @endauth
                    <x-default-button :link="route('forum.index')" class="w-full mt-3 text-base font-medium sm:mt-0 sm:ml-3 sm:shrink-0 sm:inline-flex sm:items-center sm:w-auto">
                        {{ __('Visiter le Forum') }}
                    </x-default-button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-10 lg:py-12 xl:pb-14">
            <p class="text-center text-lg font-medium leading-8 text-skin-inverted-muted">
                {{ __('Nous travaillons avec d’autres communautés et startups') }}
            </p>
            <div class="mt-5 flex items-center justify-center flex-wrap gap-8">
                <div class="flex items-center justify-center px-2">
                    <a href="https://laravelshopper.io" target="_blank" class="flex items-center">
                        <img class="h-12 logo-white" src="{{ asset('/images/sponsors/shopper-logo.svg') }}" alt="Laravel Shopper">
                        <img class="h-12 logo-dark" src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}" alt="Laravel Shopper">
                    </a>
                </div>
                <div class="flex items-center justify-center px-2">
                    <a href="https://gdg.community.dev/gdg-douala" class="flex items-center" target="_blank">
                        <x-icon.gdg class="h-7 text-skin-inverted" />
                    </a>
                </div>
                <div class="flex items-center justify-center px-2">
                    <a href="https://notchpay.co" class="flex items-center" target="_blank">
                        <x-icon.notchpay class="w-auto h-8 text-skin-inverted"/>
                    </a>
                </div>
                <div class="flex items-center justify-center px-2">
                    <a href="https://www.dark-code.cm" class="flex items-center" target="_blank">
                        <x-icon.darkcode class="w-auto h-6 text-skin-inverted"/>
                    </a>
                </div>
                <div class="flex items-center justify-center px-2">
                    <a href="https://sharuco.lndev.me" class="flex items-center" target="_blank">
                        <x-icon.sharuco class="w-auto h-7 text-skin-inverted"/>
                        <span class="ml-1 text-2xl text-skin-inverted font-bold">Sharuco</span>
                    </a>
                </div>
            </div>
            <div class="mt-6 text-center lg:mt-10">
                <a class="text-sm leading-5 text-flag-green hover:text-green-600 hover:underline" href="{{ route('sponsors') }}">
                    {{ __('Votre logo ici ?') }}
                </a>
            </div>
        </div>
    </div>

    <x-container class="px-4 mx-auto max-w-7xl">
        <div class="divide-y divide-skin-base">
            <div class="py-12 lg:py-20">
                <x-section-header
                    title="Articles Populaires"
                    content="Découvrez les articles les plus appréciés et partagés par les membres de la communauté"
                />
                <div class="grid max-w-xl gap-10 mx-auto mt-8 lg:grid-rows-3 lg:grid-flow-col lg:grid-cols-2 lg:mt-10 lg:gap-x-8 lg:max-w-none">
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
                        {{ __('Voir tous les articles') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </x-button>
                </div>
            </div>

            @if($latestThreads->isNotEmpty())
                <div class="py-12 lg:py-20">
                    <x-section-header
                        title="On apprend aussi en aidant les autres"
                        content="En rejoignant la communauté, vous pouvez consulter les dernières questions non résolues et apporter votre pierre à l’édifice."
                    />
                    <div class="grid gap-10 mt-10 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12 lg:mt-12">
                        @foreach($latestThreads as $thread)
                            <div>
                                <div class="flex items-center font-sans text-skin-base">
                                    <a href="{{ route('profile', $thread->user->username) }}" class="inline-flex items-center hover:underline">
                                        <x-user.avatar :user="$thread->user" class="h-6 w-6" container="mr-1.5" span="-right-1 -top-1 w-4 h-4 ring-1" />
                                        <span class="font-sans">{{ '@' . $thread->user->username }}</span>
                                    </a>
                                    <span class="inline-flex mx-1.5 space-x-1.5">
                                        <span>{{ __('a posé') }}</span>
                                        <time class="sr-only" datetime="{{ $thread->created_at }}" title="{{ $thread->last_posted_at->format('j M, Y \à H:i') }}">{{ $thread->last_posted_at->format('j M, Y \à H:i') }}</time>
                                        <time-ago time="{{ $thread->created_at->getTimestamp() }}"/>
                                    </span>
                                </div>
                                <a href="{{ route('forum.show', $thread) }}" class="block mt-3">
                                    <p class="font-sans text-xl font-medium text-skin-inverted">
                                        {{ $thread->subject() }}
                                    </p>
                                    <p class="mt-3 text-base font-normal text-skin-base">
                                        {!! $thread->excerpt() !!}
                                    </p>
                                </a>
                                <div class="mt-3">
                                    <a href="{{ route('forum.show', $thread) }}" class="text-base font-medium text-green-600 hover:text-green-500 hover:underline">
                                        {{ __('Afficher la question') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-center mt-10 sm:mt-12 xl:mt-16">
                        <x-button :link="route('forum.index')">
                            {{ __('Voir tous les sujets') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </x-button>
                    </div>
                </div>
            @endif

            <div class="py-12 lg:py-20">
                <x-section-header
                    title="Ou venez juste discuter"
                    content="Dans la communauté on partage aussi des sujets de discussions dans divers domaines, pour nous édifier tous ensemble. Rejoins nous en participant"
                />

                <div class="grid gap-8 mt-8 md:grid-cols-3 md:gap-x-10 lg:mt-12">
                    @foreach($latestDiscussions as $discussion)
                        <div>
                            <div class="flex items-center font-sans text-sm text-skin-muted">
                                <a class="shrink-0" href="/user/{{ $discussion->user->username }}">
                                    <x-user.avatar :user="$discussion->user" class="h-6 w-6" container="mr-1.5" span="-right-1 -top-1 w-4 h-4 ring-1" />
                                </a>
                                <span class="pr-1 ml-2">{{ __('Posté par') }}</span>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('profile', $discussion->user->username) }}" class="text-skin-inverted hover:underline">{{ $discussion->user->name }}</a>
                                    <span aria-hidden="true">&middot;</span>
                                    <time-ago time="{{ $discussion->created_at->getTimestamp() }}"/>
                                </div>
                            </div>
                            <a href="{{ route('discussions.show', $discussion) }}" class="block mt-2">
                                <p class="text-xl font-semibold text-skin-inverted">{{ $discussion->title }}</p>
                                <p class="mt-3 text-base text-skin-base">{!! $discussion->excerpt() !!}</p>
                            </a>
                            <div class="mt-3">
                                <a href="{{ route('discussions.show', $discussion) }}" class="text-base font-medium text-flag-green hover:underline hover:text-green-500">
                                    {{ __('Lire la discussion') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-center mt-10 sm:mt-12 xl:mt-16">
                    <x-button :link="route('discussions.index')">
                        {{ __('Voir toutes les discussions') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </x-button>
                </div>
            </div>
        </div>
    </x-container>

    <div class="relative bg-black">
        <div class="absolute bottom-0 w-full h-80 xl:inset-0 xl:h-full">
            <div class="w-full h-full xl:grid xl:grid-cols-2">
                <div class="h-full xl:relative xl:col-start-2">
                    <img class="object-cover w-full h-full opacity-25 xl:absolute xl:inset-0" src="{{ asset('/images/developer.jpg') }}" alt="Developer working on laptop"/>
                    <div aria-hidden="true" class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-black xl:inset-y-0 xl:left-0 xl:h-full xl:w-32 xl:bg-gradient-to-r"></div>
                </div>
            </div>
        </div>
        <div class="max-w-4xl px-4 mx-auto lg:max-w-7xl xl:grid xl:grid-cols-2 xl:grid-flow-col-dense xl:gap-x-8">
            <div class="relative pt-12 pb-64 sm:pt-24 sm:pb-64 xl:col-start-1 xl:pb-24">
                <h2 class="text-sm font-semibold tracking-wide text-green-300 uppercase font-heading">
                    {{ __('A propos') }}
                </h2>
                <p class="mt-3 text-3xl font-extrabold text-white">
                    {{ __('Nous construisons une communauté Open Source d\'apprenants et d\'enseignants') }}
                </p>
                <p class="mt-5 text-lg text-gray-400">
                    <span class="text-white">
                        <span class="italic text-skin-primary">"</span>
                        {{ __('Tout le monde enseigne, tout le monde apprend') }}
                        <span class="italic text-skin-primary">"</span>
                    </span>.
                    {{ __('Tel est l\'esprit qui est derrière la communauté. Une communauté qui se veut grandissante et qui donne la possibilité à tout le monde de partager ses connaissances et d\'apprendre.') }}
                </p>
                <div class="grid grid-cols-1 mt-12 gap-y-12 gap-x-6 sm:grid-cols-2">
                    <p>
                        <span class="block text-2xl text-white font-heading">600+</span>
                        <span class="block mt-1 text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('Membres') }}</span>
                            {{ __('qui ont rejoint les différents groupes de la communauté') }}
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl text-white font-heading">50K+</span>
                        <span class="block mt-1 text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('Développeurs PHP & Laravel') }}</span>
                            {{ __('dans l’ensemble du territoire national.') }}
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl text-white font-heading">9%</span>
                        <span class="block mt-1 text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('Taux de participation aux événements') }}</span>
                            {{ __('car la communauté est encore très jeune.') }}
                        </span>
                    </p>

                    <p>
                        <span class="block text-2xl text-white font-heading">10K+</span>
                        <span class="block mt-1 text-base text-gray-400">
                            <span class="font-medium text-white">stars</span>
                            {{ __('sur les projets réalisés par les développeurs Camerounais sur Github.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @feature('premium')
        @if($plans->count() > 0)
            <div class="relative pt-12 overflow-hidden sm:pt-16 lg:pt-20">
                <div class="z-0 hidden overflow-hidden opacity-50 pointer-events-none lg:block">
                    <testimonies-area />
                </div>
                <div class="relative z-50 pb-12 lg:-mt-16 bg-gradient-to-t from-transparent via-skin-card to-skin-body sm:pb-16 lg:pb-20">
                    <div class="px-4 mx-auto max-w-7xl">
                        <div class="lg:text-center">
                            <div class="inline-flex items-center space-x-2 px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-600">
                                <svg class="w-5 h-5 t" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M23 9.04c0-1.249-1.051-2.27-2.335-2.27-1.285 0-2.336 1.021-2.336 2.27 0 .703.35 1.36.888 1.77l-3.083 2.29-2.99-3.857c.724-.386 1.215-1.135 1.215-1.975C14.359 6.021 13.308 5 12.023 5 10.74 5 9.688 6.021 9.688 7.27c0 .839.467 1.588 1.191 1.974L7.633 13.1 4.76 10.832c.537-.408.91-1.066.91-1.793 0-1.248-1.05-2.269-2.335-2.269C2.051 6.77 1 7.791 1 9.04c0 1.111.817 2.042 1.915 2.223l1.121 5.696v2.36c0 .386.304.681.7.681h14.527c.397 0 .7-.295.7-.68v-2.36l1.122-5.697C22.183 11.082 23 10.151 23 9.04zm-2.335-.908c.513 0 .934.408.934.907 0 .5-.42.908-.934.908s-.935-.408-.935-.908c0-.499.42-.907.934-.907zM12 6.339c.514 0 .934.408.934.908 0 .499-.42.907-.934.907s-.934-.408-.934-.907c0-.5.42-.908.934-.908zm-4.18 8.396a.727.727 0 0 0 .467-.25l3.69-4.47 3.456 4.448c.117.136.28.25.467.272a.683.683 0 0 0 .514-.136l3.036-2.247-.77 3.858H5.32l-.747-3.79 2.733 2.156c.14.114.327.182.514.16zM2.4 9.04c0-.499.42-.907.934-.907s.935.408.935.907c0 .5-.42.908-.935.908-.513 0-.934-.408-.934-.908zm3.036 9.6v-1.067h13.126v1.066H5.437z" />
                                </svg>
                                <h2 class="text-lg font-semibold">{{ __('Premium') }}</h2>
                            </div>
                            <h4 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-skin-inverted sm:text-4xl font-heading">
                                {{ __('Accès illimité avec un abonnement premium') }}
                            </h4>
                            <p class="max-w-2xl mt-4 text-xl text-skin-base lg:mx-auto">
                                {{ __('Devenir premium c\'est soutenir la communauté, les nouveaux contenus chaque semaine et accéder à du contenu exclusif pour apprendre et progresser.') }}
                            </p>
                        </div>
                        <div class="mt-16 space-y-12 lg:mt-20 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:space-y-0 lg:max-w-4xl lg:mx-auto">
                            @foreach ($plans as $plan)
                                <div class="relative flex flex-col p-8 border shadow-sm rounded-2xl border-skin-base bg-skin-card/50 backdrop-blur-sm">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-skin-inverted">{{ $plan->title }}</h3>
                                        @if($plan->slug === 'le-pro')
                                            <p class="inline-flex items-center absolute top-0 -translate-y-1/2 transform rounded-full bg-flag-yellow py-1.5 px-4 text-sm font-semibold text-yellow-900">
                                                <svg class="w-5 h-5 mr-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                                </svg>
                                                {{ __('Populaire') }}
                                            </p>
                                        @endif
                                        <p class="flex items-baseline mt-4 text-skin-inverted">
                                            <span class="text-4xl font-bold tracking-tight" x-data="{ price: 0 }" x-init="price = formatMoney({{ $plan->price }})">
                                                <span x-text="price"></span>
                                            </span>
                                            <span class="ml-1 text-xl font-semibold">{{ __('/mois') }}</span>
                                        </p>

                                        <!-- Feature list -->
                                        <ul role="list" class="mt-6 space-y-6">
                                            @foreach ($plan->features as $feature)
                                                <li class="flex">
                                                    <svg class="flex-shrink-0 w-6 h-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                    </svg>
                                                    <span class="ml-3 text-skin-base">{{ $feature->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <x-button link="#" class="w-full mt-10">{{ __('Souscrire Maintenant') }}</x-button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endfeature
@stop
