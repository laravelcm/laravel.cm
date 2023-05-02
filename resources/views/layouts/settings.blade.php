@title('Paramètres')

@extends('layouts.default')

@section('body')

    <div class="pb-5 border-b border-skin-base">
        <h3 class="text-3xl font-semibold text-skin-inverted font-heading">
            {{ __('Paramètres') }}
        </h3>
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-11 lg:gap-8">
        <div class="hidden lg:block lg:col-span-2">
            <nav aria-label="Sidebar" class="sticky top-4">
                <div class="space-y-2">
                    <x-nav-link :href="route('user.settings')" :active="request()->routeIs('user.settings')">
                        <svg class="shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.settings')) text-green-600 @else text-skin-muted  @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        {{ __('Mon profil') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.password')" :active="request()->routeIs('user.password')">
                        <svg class="shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.password')) text-green-600 @else text-skin-muted  @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        {{ __('Mot de passe') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.customization')" :active="request()->routeIs('user.customization')">
                        <svg class="shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.customization')) text-green-600 @else text-skin-muted @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
                        </svg>
                        {{ __('Apparence') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.notifications')" :active="request()->routeIs('user.notifications')">
                        <svg class="shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.notifications')) text-green-600 @else text-skin-muted @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                        {{ __('Notifications') }}
                    </x-nav-link>

                    <x-nav-link href="#" :active="request()->routeIs('user.subscription')">
                        <svg class="shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.subscription')) text-green-600 @else text-skin-muted @endif" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        {{ __('Abonnement') }}
                    </x-nav-link>
                </div>
            </nav>
        </div>
        <main class="lg:col-span-9">
            {{ $slot }}
        </main>
    </section>

@endsection
