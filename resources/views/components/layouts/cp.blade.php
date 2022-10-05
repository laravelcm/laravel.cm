@props(['title'])

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
    </title>
    <link rel="canonical" href="{{ $canonical ?? Request::url() }}" />

    @include('layouts._og')
    <x-seo::meta />

    <!-- Styles -->
    @googlefonts
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
    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>

    @include('layouts._favicons')
</head>
<body class="font-sans antialiased bg-skin-body text-skin-base">

    <div class="relative overflow-hidden min-h-full">
        <x-layouts.admin-menu />

        <div class="py-12 lg:pb-20">
            {{ $slot }}
        </div>

        <x-layouts.footer />
    </div>

    @livewire('livewire-ui-modal')
    @livewire('livewire-ui-spotlight')
    @stack('scripts')
</body>
</html>
