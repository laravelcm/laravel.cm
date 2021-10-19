@title('Paramètres')

@extends('layouts.default')

@section('body')

    <div class="pb-5 border-b border-skin-base">
        <h3 class="text-3xl font-semibold text-skin-inverted font-sans">
            Paramètres
        </h3>
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-12 lg:gap-16">
        <div class="hidden lg:block lg:col-span-3">
            <nav aria-label="Sidebar" class="sticky top-4 divide-y divide-gray-300">
                <div class="space-y-2">
                    <x-nav-link :href="route('user.settings')" :active="request()->routeIs('user.settings')">
                        <x-heroicon-o-user-circle class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.settings')) text-green-600 @else text-skin-muted  @endif " />
                        {{ __('Mon profil') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.password')" :active="request()->routeIs('user.password')">
                        <x-heroicon-o-lock-closed class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.password')) text-green-600 @else text-skin-muted  @endif " />
                        {{ __('Mot de passe') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.customization')" :active="request()->routeIs('user.customization')">
                        <x-heroicon-o-template class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.customization')) text-green-600 @else text-skin-muted  @endif " />
                        {{ __('Apparence') }}
                    </x-nav-link>

                    <x-nav-link href="#" :active="request()->routeIs('user.notifications')">
                        <x-heroicon-o-speakerphone class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.notifications')) text-green-600 @else text-skin-muted  @endif " />
                        {{ __('Notifications') }}
                    </x-nav-link>

                    <x-nav-link href="#" :active="request()->routeIs('user.subscription')">
                        <x-heroicon-o-speakerphone class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 @if(request()->routeIs('user.subscription')) text-green-600 @else text-skin-muted  @endif " />
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
