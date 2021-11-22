<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo::meta />

    <title>
        {{ isset($title) ? $title . ' | ' : '' }}
        {{ config('app.name') }}
        {{ is_active('home') ? '- La plus grande communauté de développeurs Laravel & PHP au Cameroun' : '' }}
    </title>
    <meta property="og:site_name" content="Laravel.cm"/>
    <meta property="og:language" content="fr"/>
    <meta name="twitter:author" content="@laravelcm"/>

    <!-- Styles -->
    <link href="https://fonts.cdnfonts.com/css/operator-mono" rel="stylesheet">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    <script>
        window.csrfToken = {!! json_encode(['csrfToken' => csrf_token()]) !!};
        window.laravel = {
            ...(window.laravel || {}),
            isModerator: {{ auth()->check() && auth()->user()->hasAnyRole('admin', 'moderator') ? 'true' : 'false' }},
            user: {{ auth()->check() ? auth()->id() : 'null' }},
            currentUser: {!! auth()->check() ? json_encode(auth()->user()->profile()) : 'null'  !!}
        }
    </script>

    <!-- Scripts -->
    <wireui:scripts />
    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>

    @include('layouts._favicons')
    @include('layouts._fathom')
    @include('layouts._og')
</head>
<body class="antialiased font-mono bg-skin-body">

    @yield('content')

    <x-notifications z-index="z-50" />

    @livewire('livewire-ui-modal')
    @stack('scripts')
</body>
</html>
