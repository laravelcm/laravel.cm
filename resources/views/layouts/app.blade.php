@props(['title' => null, 'canonical' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth {{ get_current_theme() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        {{ isset($title) ? $title . ' | ' : '' }} {{ config('app.name') }}
        {{ is_active('home') ? '- '. __('pages/home.title') : '' }}
    </title>
    <meta name="description" content="{{ __('pages/home.description') }}" />
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
<body class="h-full bg-gray-50 font-sans text-gray-500 antialiased dark:text-gray-400 dark:bg-gray-900">
    <div id="main-site" class="flex min-h-screen flex-col justify-between">
        <x-layouts.header {{ $attributes->class($attributes->get('header-class')) }} />

        <main class="relative z-20 w-full flex-1">
            {{ $slot }}
        </main>

        <x-layouts.footer />
    </div>

    {{-- @livewire('livewire-ui-spotlight') --}}
    @livewire('wire-elements-modal')
    @livewire(\Filament\Notifications\Livewire\Notifications::class)
    @livewire(\Laravelcm\LivewireSlideOvers\SlideOverPanel::class)

    @filamentScripts
    @livewireScriptConfig
    @stack('scripts')
</body>
</html>
