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
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">{{ __('Adresse E-mail') }}</label>
                        <x-email id="email-address" name="email" autocomplete="email" required class="appearance-none rounded-none rounded-t-md focus:z-10" placeholder="{{ __('Adresse E-mail') }}" />
                    </div>
                    <div>
                        <label for="password" class="sr-only">{{ __('Mot de passe') }}</label>
                        <x-password id="password" name="password" autocomplete="current-password" required class="appearance-none rounded-none rounded-b-md focus:z-10" placeholder="{{ __('Mot de passe') }}" />
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
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-skin-light rounded-md shadow-sm bg-skin-button text-sm font-normal text-skin-base hover:bg-skin-button-hover">
                            <span class="sr-only">{{ __('Créer son compte avec Github') }}</span>
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                            </svg>
                            Github
                        </a>
                    </div>

                    <div>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-skin-light rounded-md shadow-sm bg-skin-button text-sm font-normal text-skin-base hover:bg-skin-button-hover">
                            <span class="sr-only">{{ __('Créer son compte avec Gmail') }}</span>
                            <svg  class="w-5 h-5 mr-2 -ml-1" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <g clip-path="url(#clip0)">
                                    <path d="M20.49 10.187c0-.82-.069-1.417-.216-2.037H10.7v3.698h5.62c-.113.919-.725 2.303-2.084 3.233l-.02.124 3.028 2.292.21.02c1.926-1.738 3.036-4.296 3.036-7.33z" fill="#4285F4"/>
                                    <path d="M10.7 19.931c2.753 0 5.064-.886 6.753-2.414l-3.218-2.436c-.862.587-2.018.997-3.536.997a6.126 6.126 0 0 1-5.801-4.141l-.12.01-3.148 2.38-.041.112c1.677 3.256 5.122 5.492 9.11 5.492z" fill="#34A853"/>
                                    <path d="M4.898 11.937a6.009 6.009 0 0 1-.34-1.971c0-.687.124-1.351.328-1.971l-.005-.132-3.188-2.42-.104.05A9.79 9.79 0 0 0 .5 9.965a9.79 9.79 0 0 0 1.088 4.473l3.309-2.502z" fill="#FBBC05"/>
                                    <path d="M10.7 3.853c1.914 0 3.206.809 3.943 1.484l2.878-2.746C15.753.985 13.453 0 10.699 0 6.711 0 3.266 2.237 1.59 5.492l3.297 2.503A6.152 6.152 0 0 1 10.7 3.853z" fill="#EB4335"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <path fill="#fff" transform="translate(.5)" d="M0 0h20v20H0z"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
