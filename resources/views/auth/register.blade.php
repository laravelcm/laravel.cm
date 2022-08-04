@title('Créer un compte')

@extends('layouts.default')

@section('body')

    <div class="w-full mx-auto flex items-center justify-between py-6 sm:py-9 sm:max-w-4xl">
        <div class="hidden lg:block lg:w-90">
            <h3 class="text-lg leading-6 font-semibold font-sans text-skin-inverted">
                {{ __('Ouvrez votre esprit pour découvrir de nouveaux horizons.') }}
            </h3>
            <dl class="mt-6 space-y-4">
                <div class="relative">
                    <dt>
                        <x-icon.podcast class="absolute h-6 w-6"/>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted font-medium">{{ __('Podcast') }}.</span>
                        <span>
                            {{ __('Suivez des podcasts sur différentes thématiques avec des freelances, développeurs, entrepreneurs etc.') }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.discussion class="absolute h-6 w-6"/>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted font-medium">{{ __('Discussions') }}.</span>
                        <span>
                            {{ __('Participez a des discussions et débats ouverts avec plusieurs autres participants.') }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.code-snippet class="absolute h-6 w-6" />
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted font-medium">{{ __('Code Snippets') }}.</span>
                        <span>
                            {{ __("Partagez des codes sources de différents langages pour venir en aide a d’autres développeurs.") }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.premium class="absolute h-6 w-6"/>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted font-medium">{{ __('Premium') }}.</span>
                        <span>
                            {{ __('Devenez premium, supporter la communauté et accéder à des contenus et codes sources privés.') }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        <div class="mx-auto max-w-md lg:mx-0 space-y-8">
            <div class="space-y-3">
                <h2 class="text-3xl font-extrabold text-skin-inverted font-heading">
                    {{ __('Rejoindre Laravel Cameroun') }}
                </h2>
                <x-profile-users />
                <p class="text-base leading-6 text-skin-base">
                    {{ __("Rejoignez plus de 200 développeurs et designers. Parce qu’il y’a pas que le code dans la vie.") }}
                </p>
            </div>
            <div>
                <x-status-message />

                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <x-input id="name" name="name" autocomplete="name" required placeholder="{{ __('Nom complet') }}" aria-label="{{ __('Nom complet') }}" />
                        <x-email id="email" name="email" autocomplete="email" required placeholder="{{ __('Adresse E-mail') }}" aria-label="{{ __('Adresse E-mail') }}" />
                        <x-input id="username" name="username" autocomplete="current-password" required placeholder="{{ __('Pseudo') }}" aria-label="{{ __('Pseudo') }}" />
                        <x-password id="password" name="password" autocomplete="current-password" required placeholder="{{ __('Mot de passe (min. 6 caratères)') }}" aria-label="{{ __('Mot de passe') }}" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="opt_in" name="opt_in" type="checkbox" class="h-4 w-4 bg-skin-input text-green-600 focus:ring-green-500 border-skin-input rounded">
                            <label for="opt_in" class="ml-2 block text-sm text-skin-base font-normal">
                                {{ __('Je veux recevoir la newsletter') }}
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <x-heroicon-s-lock-closed class="h-5 w-5 text-green-500 group-hover:text-green-400" />
                            </span>
                            {{ __('Créer mon compte') }}
                        </button>
                    </div>
                </form>
            </div>

            @include('partials._socials-link')
        </div>
    </div>

@stop
