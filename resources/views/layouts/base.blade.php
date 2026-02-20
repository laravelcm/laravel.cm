@props([
    'title' => null,
    'canonical' => null,
])

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
    @if ($title)
        <title>
            {{ $title }} | {{ __('global.site_name') }}
            {{ is_active('home') ? '- '. __('pages/home.title') : '' }}
        </title>
    @endif

    <x-seo::meta />

    @if (request()->is('account*') || request()->is('dashboard*'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@100..900&family=Fira+Code:wght@400;500&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-VNZ1H578TL"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-VNZ1H578TL');
        </script>
    @endproduction

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @auth
                Flux.appearance = @js(get_current_theme());
            @else
                Flux.appearance = 'system';
            @endauth
        });
    </script>
</head>
<body class="h-full font-sans text-gray-500 antialiased dark:text-gray-400 dark:bg-line-black selection:bg-primary-500 selection:text-white">
    @persist('bb-banner')
        <div id="bb-banner-container" class="fixed inset-x-0 top-0 z-50"></div>
    @endpersist

    {{ $slot }}

    <x-notify::notify />
    <livewire:slide-over-panel />

    @persist('toast')
        <flux:toast position="top end" />
    @endpersist

    @fluxScripts
    @stack('scripts')

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('theme-changed', (event) => {
                Flux.appearance = Array.isArray(event) ? event[0] : event;
            });
        });

        const bbScript = document.createElement('script');
        bbScript.async = true;
        bbScript.src = 'https://media.bitterbrains.com/main.js?from=LARAVELCM&type=top';
        document.body.appendChild(bbScript);

        (function () {
            const container = document.getElementById('bb-banner-container');
            const update = () => {
                const banner = container.querySelector('#bb-banner');
                const height = banner ? banner.getBoundingClientRect().height : 0;
                document.documentElement.style.setProperty('--banner-height', height + 'px');
            };

            const observer = new MutationObserver(update);
            observer.observe(container, { childList: true, subtree: true });

            document.addEventListener('livewire:navigated', update);
        })();
    </script>
</body>
</html>
