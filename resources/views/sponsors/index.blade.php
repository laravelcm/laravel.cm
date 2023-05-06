@title(__('Soutenir Laravel Cameroun'))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-10 lg:gap-10">
        <div class="lg:col-span-7">
            Page de sponsoring
        </div>
        <div class="mt-5 lg:mt-0 lg:col-span-3">
            <x-sticky-content>
                <div class="overflow-hidden border border-skin-base rounded-md">
                    <div class="px-4 py-3 text-skin-base bg-skin-card flex items-center flex-wrap">
                        <span>{{ __('Sponsorisé comme') }}</span>
                        @auth
                            <span class="text-sm inline-flex items-center space-x-2 ml-3">
                                <img class="h-5 w-5 object-cover rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                <span class="font-medium text-skin-inverted">{{ Auth::user()->username() }}</span>
                            </span>
                        @else
                            <span class="ml-2">
                                {{ __('anonyme ou') }}
                                <a href="{{ route('login') }}" class="text-sm text-primary-500 underline font-medium">
                                    {{ __('se connecter') }}
                                </a>
                            </span>
                        @endauth
                    </div>
                    @auth
                        <div class="p-4 flex items-center border-t border-skin-base bg-skin-card-muted">
                            <span class="relative inline-block">
                              <img class="h-10 w-10 rounded-full ring-2 ring-yellow-500" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username() }}">
                              <span class="absolute -right-1 top-0 flex items-center justify-center h-4 w-4 rounded-full bg-white ring-2 ring-yellow-500">
                                  <svg class="w-3 h-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                  </svg>
                              </span>
                            </span>
                            <p class="flex-1 ml-4 text-sm leading-5 text-skin-base">
                                {{ __('Voici le badge sur votre avatar que vous obtiendrez et qui indique que vous êtes un sponsor de @laravelcm.') }}
                            </p>
                        </div>
                    @endauth
                </div>
            </x-sticky-content>
        </div>
    </div>

@endsection
