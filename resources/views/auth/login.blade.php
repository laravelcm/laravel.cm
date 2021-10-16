@title('Se connecter')

@extends('layouts.default')

@section('body')

    <div class="flex items-center justify-center min-h-full py-16 sm:py-24">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-skin-inverted font-sans">
                    {{ __('Se connecter à son compte') }}
                </h2>
            </div>
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email-address" class="sr-only">{{ __('Adresse E-mail') }}</label>
                        <x-email id="email-address" name="email" autocomplete="email" required placeholder="{{ __('Adresse E-mail') }}" />
                    </div>
                    <div>
                        <label for="password" class="sr-only">{{ __('Mot de passe') }}</label>
                        <x-password id="password" name="password" autocomplete="current-password" required placeholder="{{ __('Mot de passe') }}" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-green-600 bg-skin-input focus:ring-green-500 border-skin-input rounded" />
                        <label for="remember_me" class="ml-2 block text-sm text-skin-base font-normal cursor-pointer">
                            {{ __('Se souvenir de moi') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                            {{ __('Mot de passe oublié?') }}
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <x-heroicon-s-lock-closed class="h-5 w-5 text-green-500 group-hover:text-green-400" />
                        </span>
                        {{ __('Se connecter') }}
                    </button>
                </div>
            </form>
            <div>
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-skin-light"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-skin-body text-skin-base font-normal">
                            {{ __('Ou continuer avec') }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-2">
                    <div>
                        <a href="{{ route('social.auth', ['provider' => 'github']) }}" class="w-full inline-flex justify-center py-2 px-4 border border-skin-light rounded-md shadow-sm bg-skin-button text-sm font-normal text-skin-base hover:bg-skin-button-hover">
                            <span class="sr-only">{{ __('Créer son compte avec Github') }}</span>
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                            </svg>
                            Github
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('social.auth', ['provider' => 'twitter']) }}" class="w-full inline-flex justify-center py-2 px-4 border border-skin-light rounded-md shadow-sm bg-skin-button text-sm font-normal text-skin-base hover:bg-skin-button-hover">
                            <span class="sr-only">{{ __('Créer son compte avec Twitter') }}</span>
                            <svg class="w-5 h-5 mr-2 -ml-1 text-[#1E9DEA]" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                            Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
