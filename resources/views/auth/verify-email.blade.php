@title('Vérification de l\'adresse e-mail')

@extends('layouts.master')

@section('content')

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <img class="h-12 w-auto sm:h-16 logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
            <img class="h-12 w-auto sm:h-16 logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
        </div>

        <div class="w-full sm:max-w-md lg:max-w-xl mt-6 lg:mt-10">
            <div class="mb-4 text-sm text-skin-base text-center">
                {{ __('Merci pour votre inscription! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail? Si vous n\'avez pas reçu l\'e-mail, nous nous ferons un plaisir de vous en envoyer un autre.') }}
            </div>

            <div class="mt-8 px-6 py-4 bg-skin-card shadow-md overflow-hidden sm:rounded-lg">
                @if (session('status') == 'verification-link-sent')
                    <div class="rounded-md bg-green-50 p-4 mb-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <x-heroicon-s-check-circle class="h-5 w-5 text-green-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail que vous avez fournie lors de l\'inscription ou la modification de votre adresse.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-button type="submit">
                                {{ __('Renvoyer l\'e-mail de vérification') }}
                            </x-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="underline text-sm text-skin-base hover:text-skin-inverted focus:outline-none">
                            {{ __('Se déconnecter') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
