<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) ? $title . ' | ' : '' }}
        {{ config('app.name') }}
        {{ is_active('home') ? '- La plus grande communauté de développeurs Laravel & PHP au Cameroun' : '' }}
    </title>
    <meta name="description" content="Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, on partage, on apprend, on découvre et on construit une grande communauté.">
    <meta property="og:site_name" content="Laravel.cm"/>
    <meta property="og:language" content="fr"/>
    <meta name="twitter:author" content="@laravelcm"/>
    <link rel="canonical" href="{{ $canonical ?? Request::url() }}" />

    @include('layouts._og')
    <x-seo::meta />

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
</head>
<body class="antialiased font-mono bg-skin-body">

    <div class="relative overflow-hidden min-h-full">
        <div class="winter-is-coming">

            <div class="snow snow--near"></div>
            <div class="snow snow--near snow--alt"></div>

            <div class="snow snow--mid"></div>
            <div class="snow snow--mid snow--alt"></div>

            <div class="snow snow--far"></div>
            <div class="snow snow--far snow--alt"></div>
        </div>

        @yield('content')
    </div>

    <div class="guirlande h-[120px] -top-8" style="background: url('{{ asset('/images/guirlande1.png') }}') repeat-x 300% top"></div>
    <div class="guirlande top-[-75px]" style="background: url('{{ asset('/images/guirlande2.png') }}') repeat-x 70% top"></div>
    <div class="guirlande top-[-50px]" style="background: url('{{ asset('/images/guirlande3.png') }}') repeat-x 10% top"></div>

    <x-notifications z-index="z-50" />

    @livewire('livewire-ui-modal')
    @livewire('livewire-ui-spotlight')
    @stack('scripts')
</body>
</html>
