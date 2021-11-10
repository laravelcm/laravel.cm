<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) ? $title.' | ' : '' }}
        {{ config('app.name') }}
        {{ is_active('home') ? '- La plus grande communauté de développeurs Laravel & PHP au Cameroun' : '' }}
    </title>

    <!-- Styles -->
    <link href="https://fonts.cdnfonts.com/css/operator-mono" rel="stylesheet">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    @stack('meta')

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    <wireui:scripts />
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @include('layouts._favicons')
    @include('layouts._fathom')
    @include('layouts._og')
</head>
<body class="antialiased font-mono bg-skin-body">

    @yield('content')

    <x-notifications z-index="z-50" />
    @livewireScripts
    @livewire('livewire-ui-modal')
    @stack('scripts')
</body>
</html>
