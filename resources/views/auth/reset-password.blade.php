@title('Réinitialiser votre mot de passe')

@extends('layouts.default')

@section('body')

    <div class="flex items-center justify-center min-h-full py-16 sm:py-24">
        <div class="max-w-md w-full">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-skin-inverted font-heading sm:text-left">
                    {{ __('Réinitialiser votre mot de passe') }}
                </h2>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="block">
                    <x-label for="email">{{ __('Adresse E-mail') }}</x-label>
                    <x-email id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                </div>

                <div class="block">
                    <x-label for="email">{{ __('Mot de passe') }}</x-label>
                    <x-password id="password" class="block mt-1 w-full" name="password" required autocomplete="new-password" />
                </div>

                <div class="block">
                    <x-label for="email">{{ __('Confirmer Mot de passe') }}</x-label>
                    <x-password id="password_confirmation" class="block mt-1 w-full" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Réinitialiser mot de passe') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

@stop
