<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Styles -->
    <link href="https://fonts.cdnfonts.com/css/operator-mono" rel="stylesheet">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @include('layouts._favicons')
    @include('layouts._fathom')
</head>
<body class="antialiased font-sans bg-skin-body">

    <main class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="shrink-0 pt-16">
            <img class="mx-auto h-12 w-auto sm:h-16 logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
            <img class="mx-auto h-12 w-auto sm:h-16 logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
        </div>
        <div class="max-w-xl mx-auto py-16 sm:py-24">
            <div class="text-center">
                <p class="text-sm font-semibold text-skin-primary uppercase tracking-wide font-sans">Erreur @yield('code')</p>
                <h1 class="mt-2 text-4xl font-extrabold text-skin-inverted tracking-tight sm:text-5xl font-sans">@yield('message')</h1>
                <p class="mt-2 text-lg text-skin-base font-normal">Il semble y avoir un problème en ce moment! Veuillez réessayer plus tard.</p>
            </div>
            <div class="mt-12">
                <h2 class="text-sm font-semibold text-skin-base tracking-wide uppercase font-sans">Pages Populaires</h2>
                <ul role="list" class="mt-4 border-t border-b border-skin-base divide-y divide-skin-base">
                    <li class="relative py-6 flex items-start space-x-4">
                        <div class="shrink-0">
                            <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-50">
                                <x-heroicon-o-book-open class="h-6 w-6 text-green-700" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-medium text-skin-inverted font-sans">
                                <span class="rounded-sm focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <a href="{{ route('forum.index') }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Forum
                                    </a>
                                </span>
                            </h3>
                            <p class="text-base text-skin-base font-normal">Apprenez, découvrez, partagez dans le Forum.</p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted" />
                        </div>
                    </li>

                    <li class="relative py-6 flex items-start space-x-4">
                        <div class="shrink-0">
                            <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-50">
                                <x-heroicon-o-microphone class="h-6 w-6 text-green-700" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-medium text-skin-inverted font-sans">
                                <span class="rounded-sm focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <a href="#" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Podcasts
                                    </a>
                                </span>
                            </h3>
                            <p class="text-base text-skin-base font-normal">Des émissions radios pour la culture.</p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted" />
                        </div>
                    </li>

                    <li class="relative py-6 flex items-start space-x-4">
                        <div class="shrink-0">
                          <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-50">
                              <x-heroicon-o-bookmark-alt class="h-6 w-6 text-green-700" />
                          </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-medium text-skin-inverted font-sans">
                                <span class="rounded-sm focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <a href="{{ route('rules') }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Guides
                                    </a>
                                </span>
                            </h3>
                            <p class="text-base text-skin-base font-normal">Guide d'utilisation et paramétrage du site.</p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted" />
                        </div>
                    </li>

                    <li class="relative py-6 flex items-start space-x-4">
                        <div class="shrink-0">
                            <span class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-50">
                                <x-heroicon-o-rss class="h-6 w-6 text-green-700" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-medium text-skin-inverted font-sans">
                                <span class="rounded-sm focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <a href="{{ route('articles') }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Blog
                                    </a>
                                </span>
                            </h3>
                            <p class="text-base text-skin-base font-normal">Lisez les dernières nouvelles et articles.</p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted" />
                        </div>
                    </li>
                </ul>
                <div class="mt-8">
                    <a href="{{ url('/') }}" class="text-base font-medium text-skin-primary hover:text-skin-primary-hover">
                        Ou retourner à l'accueil<span aria-hidden="true"> &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
