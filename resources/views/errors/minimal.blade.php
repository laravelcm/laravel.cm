<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <!-- Styles -->
        <link href="https://fonts.cdnfonts.com/css/operator-mono" rel="stylesheet" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" />

        @include('partials._favicons')
        @include('partials._fathom')
    </head>
    <body class="bg-skin-body font-sans antialiased">
        <main class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="shrink-0 pt-16">
                <img
                    class="logo-white mx-auto h-12 w-auto sm:h-16"
                    src="{{ asset('/images/laravelcm.svg') }}"
                    alt="Laravel.cm"
                />
                <img
                    class="logo-dark mx-auto h-12 w-auto sm:h-16"
                    src="{{ asset('/images/laravelcm-white.svg') }}"
                    alt="Laravel.cm"
                />
            </div>
            <div class="mx-auto max-w-xl py-16 sm:py-24">
                <div class="text-center">
                    <p class="font-sans text-sm font-semibold uppercase tracking-wide text-primary-600">
                        Erreur
                        @yield('code')
                    </p>
                    <h1 class="mt-2 font-sans text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                        @yield('message')
                    </h1>
                    <p class="mt-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Il semble y avoir un problème en ce moment ! Veuillez réessayer plus tard.
                    </p>
                </div>
                <div class="mt-12">
                    <h2 class="font-sans text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        Pages Populaires
                    </h2>
                    <ul role="list" class="mt-4 divide-y divide-skin-base border-b border-t border-skin-base">
                        <li class="relative flex items-start space-x-4 py-6">
                            <div class="shrink-0">
                                <span class="flex size-12 items-center justify-center rounded-lg bg-green-50">
                                    <x-heroicon-o-book-open class="size-6 text-green-700" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-sans text-base font-medium text-gray-900">
                                    <span
                                        class="rounded-sm focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2"
                                    >
                                        <a href="{{ route('forum.index') }}" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Forum
                                        </a>
                                    </span>
                                </h3>
                                <p class="text-base text-gray-500 dark:text-gray-400">Apprenez, découvrez, partagez dans le Forum.</p>
                            </div>
                            <div class="shrink-0 self-center">
                                <x-heroicon-s-chevron-right class="size-5 text-skin-muted" />
                            </div>
                        </li>

                        <li class="relative flex items-start space-x-4 py-6">
                            <div class="shrink-0">
                                <span class="flex size-12 items-center justify-center rounded-lg bg-green-50">
                                    <x-heroicon-o-microphone class="size-6 text-green-700" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-sans text-base font-medium text-gray-900">
                                    <span
                                        class="rounded-sm focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2"
                                    >
                                        <a href="#" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Podcasts
                                        </a>
                                    </span>
                                </h3>
                                <p class="text-base text-gray-500 dark:text-gray-400">Des émissions radios pour la culture.</p>
                            </div>
                            <div class="shrink-0 self-center">
                                <x-heroicon-s-chevron-right class="size-5 text-skin-muted" />
                            </div>
                        </li>

                        <li class="relative flex items-start space-x-4 py-6">
                            <div class="shrink-0">
                                <span class="flex size-12 items-center justify-center rounded-lg bg-green-50">
                                    <x-untitledui-bookmark class="size-6 text-green-700" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-sans text-base font-medium text-gray-900">
                                    <span
                                        class="rounded-sm focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2"
                                    >
                                        <a href="{{ route('rules') }}" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Guides
                                        </a>
                                    </span>
                                </h3>
                                <p class="text-base text-gray-500 dark:text-gray-400">Guide d'utilisation et paramétrage du site.</p>
                            </div>
                            <div class="shrink-0 self-center">
                                <x-heroicon-s-chevron-right class="size-5 text-skin-muted" />
                            </div>
                        </li>

                        <li class="relative flex items-start space-x-4 py-6">
                            <div class="shrink-0">
                                <span class="flex size-12 items-center justify-center rounded-lg bg-green-50">
                                    <x-heroicon-o-rss class="size-6 text-green-700" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-sans text-base font-medium text-gray-900">
                                    <span
                                        class="rounded-sm focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2"
                                    >
                                        <a href="{{ route('articles') }}" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            Blog
                                        </a>
                                    </span>
                                </h3>
                                <p class="text-base text-gray-500 dark:text-gray-400">Lisez les dernières nouvelles et articles.</p>
                            </div>
                            <div class="shrink-0 self-center">
                                <x-heroicon-s-chevron-right class="size-5 text-skin-muted" />
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a
                            href="{{ url('/') }}"
                            class="text-base font-medium text-primary-600 hover:text-primary-600-hover"
                        >
                            Ou retourner à l'accueil
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
