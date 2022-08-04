@title('Se connecter')

@extends('layouts.default')

@section('body')

    <div class="flex items-center justify-center min-h-full py-16 sm:py-24">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-skin-inverted font-heading">
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
                    <button type="submit" class="button group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <x-heroicon-s-lock-closed class="h-5 w-5 text-green-500 group-hover:text-green-400" />
                        </span>
                        {{ __('Se connecter') }}
                    </button>
                </div>
            </form>

            @include('partials._socials-link')
        </div>
    </div>

@stop
