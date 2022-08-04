@title('Réinitialisation du mot de passe')

@extends('layouts.default')

@section('body')

    <div class="flex items-center justify-center min-h-full py-16 sm:py-24">
        <div class="max-w-md w-full">
            <div>
                <x-status-message class="mb-5" />

                <h2 class="text-center text-3xl font-extrabold text-skin-inverted font-sans sm:text-left font-heading">
                    {{ __('Réinitialisation du mot de passe') }}
                </h2>
                <div class="mt-4 text-sm text-skin-base">
                    {{ __('Mot de passe oublié? Aucun problème. Communiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
                </div>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="mt-8">
                @csrf

                <div class="block">
                    <x-label for="email">{{ __('Email') }}</x-label>
                    <x-email id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button type="submit" class="relative w-full">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

@stop
