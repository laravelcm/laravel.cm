<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth {{ get_current_theme() }}">
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @include('layouts._favicons')
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

    @include('layouts._fathom')
</head>
<body class="font-sans antialiased bg-skin-body text-skin-base">

    <div class="relative min-h-full overflow-hidden">
        @yield('content')
    </div>

    <x-notifications z-index="z-50" />

    @livewire('livewire-ui-modal')
    @livewire('livewire-ui-spotlight')
    @stack('scripts')
</body>
</html>
