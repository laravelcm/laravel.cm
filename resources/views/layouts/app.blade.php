@props(['title' => null, 'canonical' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        {{ isset($title) ? $title . ' | ' : '' }} {{ __('global.site_name') }}
        {{ is_active('home') ? '- '. __('pages/home.title') : '' }}
    </title>
    <meta property="og:site_name" content="Laravel.cm" />
    <meta property="og:language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <x-seo::meta />

    @include('partials._favicons')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    @livewireStyles
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials._analytics')

    @if (! auth()->check())
        <script>
            localStorage.setItem('theme', 'light')
        </script>
    @else
        <script>
            const theme = localStorage.getItem('theme') ?? @js(auth()->user()->setting('theme', 'light'))

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
        <x-layouts.header {{ $attributes->class($attributes->get('header-class')) }} />

        <main class="relative z-20 w-full flex-1">
            {{ $slot }}
        </main>

        <x-layouts.footer />
    </div>

    @livewire('livewire-ui-spotlight')
    @livewire('wire-elements-modal')
    @livewire(\Filament\Notifications\Livewire\Notifications::class)
    @livewire(\Laravelcm\LivewireSlideOvers\SlideOverPanel::class)

    @filamentScripts
    @livewireScriptConfig
    @stack('scripts')
</body>
</html>
