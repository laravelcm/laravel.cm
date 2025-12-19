@props(['title' => null, 'canonical' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ asset('/images/favicons/site.webmanifest') }}" />
    <link rel="mask-icon" href="{{ asset('/images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#ffffff" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        {{ isset($title) ? $title . ' | ' : '' }} {{ __('global.site_name') }}
        {{ is_active('home') ? '- '. __('pages/home.title') : '' }}
    </title>
    <meta property="og:site_name" content="Laravel.cm" />
    <meta property="og:language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <x-seo::meta />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials._analytics')

    @if (! auth()->check())
        <script>
            localStorage.setItem('theme', 'dark')
        </script>
    @else
        <script>
            const theme = localStorage.getItem('theme') ?? @js(auth()->user()->setting('theme', 'dark'))

            if (
                theme === 'dark' ||
                (theme === 'system' &&
                    window.matchMedia('(prefers-color-scheme: dark)')
                        .matches)
            ) {
                document.documentElement.classList.add('dark')
            }
        </script>
    @endif
</head>
<body class="h-full bg-gray-50 font-sans text-gray-500 antialiased dark:text-gray-400 dark:bg-gray-900 selection:bg-primary-500 selection:text-gray-950">
    <div id="main-site" class="flex min-h-screen flex-col justify-between">
        <x-layouts.header />

        <main class="relative z-20 w-full flex-1">
            {{ $slot }}
        </main>

        <x-layouts.footer />
    </div>

    @livewire('livewire-ui-spotlight')
    <livewire:wire-elements-modal />
    <livewire:notifications />
    <livewire:slide-over-panel />

    @fluxScripts
    @stack('scripts')
</body>
</html>
