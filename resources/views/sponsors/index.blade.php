<x-app-layout title="Soutenir Laravel Cameroun">
    <x-container class="py-12">
        <div class="pb-12 lg:grid lg:grid-cols-10 lg:gap-10">
            <div class="space-y-4 lg:col-span-7">
                <x-status-message />
                <x-error-message />

                <div class="space-y-10">
                    <h1 class="font-heading text-2xl font-bold text-gray-900 lg:text-4xl">
                        Soutenir Laravel Cameroun
                    </h1>
                    <div class="relative flex items-center space-x-5">
                        <div class="shrink-0">
                            <x-application-icon class="block h-12 w-auto sm:h-14" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="focus:outline-none">
                                <p class="text-sm font-medium text-gray-900">Laravel Cameroun</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <a href="{{ route('twitter') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">Twitter</span>
                                        <x-icon.twitter class="size-5" />
                                    </a>

                                    <a href="{{ route('facebook') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">Facebook</span>
                                        <x-icon.facebook class="size-5" />
                                    </a>

                                    <a href="{{ route('linkedin') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">LinkedIn</span>
                                        <x-icon.linkedin class="size-5" />
                                    </a>

                                    <a href="{{ route('github') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">Github</span>
                                        <x-icon.github class="size-5" />
                                    </a>

                                    <a href="{{ route('youtube') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                                        <span class="sr-only">YouTube</span>
                                        <x-icon.youtube class="size-5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="prose prose-green mx-auto overflow-x-hidden text-gray-500 dark:text-gray-400 lg:max-w-4xl">
                        <p>
                            Bienvenue sur la page de sponsoring de Laravel Cameroun. À travers cette page, vous pouvez
                            aider à soutenir le développement de la plateforme. Laravel.cm est le portail de la
                            communauté Laravel Cameroun, un endroit pour la communauté, par la communauté. Son code est
                            entièrement
                            <a href="https://github.com/laravelcm/laravel/cm">ouvert (open source)</a>
                            et constitue une ressource d'apprentissage pour les développeurs. Les développeurs sont
                            libres de poser des
                            <a href="https://github.com/laravelcm/issues">questions</a>
                            , de contribuer au code source ou de s'inspirer pour leurs propres projets.
                        </p>
                        <p>
                            Depuis que nous avons débuté avec la communauté en 2018, nous avons consacré pas mal de
                            temps à la mise en place des fonctionnalités et à la mise à jour régulière du site. Du
                            Design à la conception, en passant par l'intégration et le choix des outils pour le
                            frontend. Et depuis lors d'autres projets sont sur le point de voir le jour grâce à ce
                            travail fourni depuis des années.
                        </p>
                        <p>
                            Avec les fonds que nous gagnerons grâce à cette page, nous voulons amener Laravel Cameroun à
                            un niveau supérieur. Nous prévoyons d'étendre la plateforme avec de nombreuses nouvelles
                            fonctionnalités et de créer le meilleur portail possible pour la communauté Laravel au
                            Cameroun. Pour ce faire, nous avons besoin de soutien.
                        </p>
                        <p>
                            Grâce aux plans de parrainage présentés sur cette page, vous pouvez nous aider. Qu'elle soit
                            petite ou grande, chaque contribution nous aidera à couvrir les coûts des prochaines étapes.
                        </p>
                        <p>
                            Merci d'envisager de sponsoriser Laravel Cameroun ! Votre aide permettra à la plateforme de
                            continuer à fonctionner et à s'améliorer.
                        </p>
                    </div>
                    <div class="border-t border-skin-base pt-12">
                        <h4 class="font-heading text-lg font-medium text-gray-900 lg:text-xl">Sponsors</h4>
                        <div class="mt-4 flex flex-wrap items-center gap-6">
                            <a href="https://laravelshopper.io" target="_blank" class="flex items-center">
                                <img
                                    class="logo-white h-10"
                                    src="{{ asset('/images/sponsors/shopper-logo.svg') }}"
                                    alt="Laravel Shopper"
                                />
                                <img
                                    class="logo-dark h-10"
                                    src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}"
                                    alt="Laravel Shopper"
                                />
                            </a>
                            <a href="https://gdg.community.dev/gdg-douala" target="_blank" class="flex items-center">
                                <x-icon.gdg class="h-6 text-gray-900" />
                            </a>
                            <a href="https://notchpay.co" class="flex items-center">
                                <x-icon.notchpay class="h-6 w-auto text-gray-900" />
                            </a>
                            <a href="https://dark-code.cm" class="flex items-center">
                                <x-icon.darkcode class="h-5 w-auto text-gray-900" />
                            </a>
                            <a href="https://sharuco.lndev.me" class="flex items-center">
                                <x-icon.sharuco class="h-5 w-auto text-gray-900" />
                                <span class="ml-1 text-xl font-bold text-gray-900">Sharuco</span>
                            </a>
                        </div>
                        <div class="mt-10 flex flex-wrap items-center">
                            <ul role="list" class="lg:grid-cols-20 grid grid-cols-6 gap-1 sm:grid-cols-12">
                                @foreach ($sponsors as $sponsor)
                                    <x-sponsor-profile :sponsor="$sponsor" />
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10 lg:col-span-3 lg:mt-0">
                <x-sticky-content class="space-y-8">
                    <div class="overflow-hidden rounded-md border border-skin-base">
                        <div class="flex flex-wrap items-center bg-skin-card px-4 py-3 text-gray-500 dark:text-gray-400">
                            @auth
                                <span>Soutenir comme</span>
                                <span class="ml-3 inline-flex items-center space-x-2 text-sm">
                                    <x-user.avatar
                                        :user="Auth::user()"
                                        class="size-5"
                                        span="-right-1 -top-1 w-3.5 h-3.5 ring-1"
                                    />
                                    <span class="font-medium text-gray-900">{{ Auth::user()->username() }}</span>
                                </span>
                            @else
                                <span>
                                    Soutenir en tant qu'invité ou
                                    <a href="{{ route('login') }}" class="font-medium text-primary-500 underline">
                                        se connecter
                                    </a>
                                </span>
                            @endauth
                        </div>
                        @auth
                            <div class="flex items-center border-t border-skin-base bg-skin-card-muted p-4">
                                <span class="relative inline-block">
                                    <img
                                        class="size-10 rounded-full ring-2 ring-yellow-500"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->username() }}"
                                    />
                                    <span
                                        class="absolute -right-1 top-0 flex size-4 items-center justify-center rounded-full bg-white ring-2 ring-yellow-500"
                                    >
                                        <svg
                                            class="h-3 w-3 text-yellow-500"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                </span>
                                <p class="ml-4 flex-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                                    Voici le badge sur votre avatar que vous obtiendrez et qui indique que vous êtes un
                                    sponsor de
                                    @laravelcm.
                                </p>
                            </div>
                        @endauth
                    </div>

                    <livewire:sponsor-subscription />
                </x-sticky-content>
            </div>
        </div>
    </x-container>
</x-app-layout>
