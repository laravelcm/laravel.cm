@title(__('Soutenir Laravel Cameroun'))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-10 lg:gap-10 pb-12">
        <div class="lg:col-span-7 space-y-4">
            <x-status-message />
            <x-error-message />

            <div class="space-y-10">
                <h1 class="text-2xl lg:text-4xl font-heading text-skin-inverted font-bold">{{ __('Soutenir Laravel Cameroun') }}</h1>
                <div class="relative flex items-center space-x-5">
                    <div class="shrink-0">
                        <x-application-icon class="block h-12 w-auto sm:h-14" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="focus:outline-none">
                            <p class="text-sm font-medium text-skin-inverted">{{ __('Laravel Cameroun') }}</p>
                            <div class="mt-2 flex items-center space-x-4">
                                <a href="{{ route('twitter') }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">{{ __('Twitter') }}</span>
                                    <x-icon.twitter class="h-5 w-5" />
                                </a>

                                <a href="{{ route('facebook') }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">{{ __('Facebook') }}</span>
                                    <x-icon.facebook class="h-5 w-5" />
                                </a>

                                <a href="{{ route('linkedin') }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">{{ __('LinkedIn') }}</span>
                                    <x-icon.linkedin class="h-5 w-5" />
                                </a>

                                <a href="{{ route('github') }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">{{ __('GitHub') }}</span>
                                    <x-icon.github class="h-5 w-5" />
                                </a>

                                <a href="{{ route('youtube') }}" class="text-skin-muted hover:text-skin-base">
                                    <span class="sr-only">{{ __('YouTube') }}</span>
                                    <x-icon.youtube class="h-5 w-5" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="prose prose-green text-skin-base mx-auto overflow-x-hidden lg:max-w-4xl">
                    <p>
                        Bienvenue sur la page de sponsoring de Laravel Cameroun. À travers cette page, vous pouvez aider à soutenir le
                        développement de la plateforme. Laravel.cm est le portail de la communauté Laravel Cameroun, un endroit pour la communauté,
                        par la communauté. Son code est entièrement <a href="https://github.com/laravelcm/laravel/cm">ouvert (open source)</a>
                        et constitue une ressource d'apprentissage pour les développeurs. Les développeurs sont libres de poser des
                        <a href="https://github.com/laravelcm/issues">questions</a>, de contribuer au code source ou de s'inspirer pour leurs propres projets.
                    </p>
                    <p>
                        Depuis que nous avons débuté avec la communauté en 2018, nous avons consacré pas mal de temps à la mise en place des fonctionnalités
                        et à la mise à jour régulière du site. Du Design à la conception, en passant par l'intégration et le choix des outils pour le frontend.
                        Et depuis lors d'autres projets sont sur le point de voir le jour grâce à ce travail fourni depuis des années.
                    </p>
                    <p>
                        Avec les fonds que nous gagnerons grâce à cette page, nous voulons amener Laravel Cameroun à un niveau supérieur.
                        Nous prévoyons d'étendre la plateforme avec de nombreuses nouvelles fonctionnalités et de créer le meilleur portail
                        possible pour la communauté Laravel au Cameroun. Pour ce faire, nous avons besoin de soutien.
                    </p>
                    <p>
                        Grâce aux plans de parrainage présentés sur cette page, vous pouvez nous aider. Qu'elle soit petite ou grande,
                        chaque contribution nous aidera à couvrir les coûts des prochaines étapes.
                    </p>
                    <p>
                        Merci d'envisager de sponsoriser Laravel Cameroun ! Votre aide permettra à la plateforme de continuer à fonctionner et à s'améliorer.
                    </p>
                </div>
                <div class="pt-12 border-t border-skin-base">
                    <h4 class="text-skin-inverted text-lg lg:text-xl font-medium font-heading">{{ __('Sponsors') }}</h4>
                    <div class="mt-4 flex items-center flex-wrap gap-6">
                        <a href="https://laravelshopper.io" target="_blank" class="flex items-center">
                            <img class="h-10 logo-white" src="{{ asset('/images/sponsors/shopper-logo.svg') }}" alt="Laravel Shopper">
                            <img class="h-10 logo-dark" src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}" alt="Laravel Shopper">
                        </a>
                        <a href="https://gdg.community.dev/gdg-douala" target="_blank" class="flex items-center">
                            <x-icon.gdg class="h-6 text-skin-inverted" />
                        </a>
                        <a href="https://notchpay.co" class="flex items-center">
                            <x-icon.notchpay class="w-auto h-6 text-skin-inverted"/>
                        </a>
                        <a href="https://dark-code.cm" class="flex items-center">
                            <x-icon.darkcode class="w-auto h-5 text-skin-inverted"/>
                        </a>
                        <a href="https://sharuco.lndev.me" class="flex items-center">
                            <x-icon.sharuco class="w-auto h-5 text-skin-inverted"/>
                            <span class="ml-1 text-xl text-skin-inverted font-bold">Sharuco</span>
                        </a>
                    </div>
                    <div class="mt-10 flex items-center flex-wrap">
                        <ul role="list" class="grid grid-cols-6 gap-1 sm:grid-cols-12 lg:grid-cols-20">
                            @foreach($sponsors as $sponsor)
                                <x-sponsor-profile :sponsor="$sponsor" />
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-10 lg:mt-0 lg:col-span-3">
            <x-sticky-content class="space-y-8">
                <div class="overflow-hidden border border-skin-base rounded-md">
                    <div class="px-4 py-3 text-skin-base bg-skin-card flex items-center flex-wrap">
                        @auth
                            <span>{{ __('Soutenir comme') }}</span>
                            <span class="text-sm inline-flex items-center space-x-2 ml-3">
                                <x-user.avatar :user="Auth::user()" class="h-5 w-5" span="-right-1 -top-1 w-3.5 h-3.5 ring-1" />
                                <span class="font-medium text-skin-inverted">{{ Auth::user()->username() }}</span>
                            </span>
                        @else
                            <span>
                                {{ __('Soutenir en tant qu\'invité ou') }}
                                <a href="{{ route('login') }}" class="text-primary-500 underline font-medium">
                                    {{ __('se connecter') }}
                                </a>
                            </span>
                        @endauth
                    </div>
                    @auth
                        <div class="p-4 flex items-center border-t border-skin-base bg-skin-card-muted">
                            <span class="relative inline-block">
                              <img class="h-10 w-10 rounded-full ring-2 ring-yellow-500" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username() }}">
                              <span class="absolute -right-1 top-0 flex items-center justify-center h-4 w-4 rounded-full bg-white ring-2 ring-yellow-500">
                                  <svg class="w-3 h-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                  </svg>
                              </span>
                            </span>
                            <p class="flex-1 ml-4 text-sm leading-5 text-skin-base">
                                {{ __('Voici le badge sur votre avatar que vous obtiendrez et qui indique que vous êtes un sponsor de @laravelcm.') }}
                            </p>
                        </div>
                    @endauth
                </div>

                <livewire:sponsor-subscription />
            </x-sticky-content>
        </div>
    </div>

@endsection
