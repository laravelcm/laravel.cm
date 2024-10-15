@props(['title' => null, 'canonical' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ get_current_theme() }} h-full scroll-smooth">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>
            {{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }}
            {{ is_active('home') ? '- La plus grande communauté de développeurs Laravel & PHP au Cameroun' : '' }}
        </title>
        <meta
            name="description"
            content="Laravel Cameroun est le portail de la communauté de développeurs PHP & Laravel au Cameroun, on partage, on apprend, on découvre et on construit une grande communauté."
        />
        <meta property="og:site_name" content="Laravel.cm" />
        <meta property="og:language" content="fr" />
        <meta name="twitter:author" content="@laravelcm" />
        <link rel="canonical" href="{{ $canonical ?? Request::url() }}" />
        @include('partials._og')
        <x-seo::meta />

        <!-- Styles -->
        @googlefonts
        @include('partials._favicons')

        @livewireStyles
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('partials._analytics')
    </head>
    <body class="h-full bg-skin-body font-sans text-skin-base antialiased">
        <div class="flex min-h-screen flex-col justify-between">
            <x-layouts.header class="header" />

            <main class="relative z-0 w-full flex-1">
                {{ $slot }}
            </main>

            <x-layouts.footer />
        </div>

        @livewire('wire-elements-modal')
        {{-- @livewire('livewire-ui-spotlight') --}}
        @livewire('notifications')

        @filamentScripts
        @livewireScriptConfig
        @stack('scripts')
    </body>
</html>
