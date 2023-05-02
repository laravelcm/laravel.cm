<x-settings-layout>

    <div class="sm:grid sm:grid-cols-5 sm:gap-12">
        <form class="sm:col-span-3 space-y-8 divide-y divide-skin-base" method="POST" action="{{ route('user.password.update') }}">
            <x-status-message />

            <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
                <div>
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                        {{ __('Mot de passe') }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                        {{ __('Vous devez renseigner votre mot de passe actuel pour changer de mot de passe.') }}
                    </p>
                </div>
                <div class="pt-6 sm:pt-5 space-y-6 sm:space-y-5">
                    @if (Auth::user()->hasPassword())
                        <div class="block">
                            <x-label for="current_password">{{ __('Mot de passe actuel') }}</x-label>
                            <x-password id="current_password" class="block mt-1 w-full" name="current_password" required autocomplete="new-password" />
                        </div>
                    @endif

                    <div class="block">
                        <x-label for="password">{{ __('Nouveau mot de passe') }}</x-label>
                        <x-password id="password" class="block mt-1 w-full" name="password" required />
                        <p class="mt-2 text-sm text-skin-muted font-normal">
                            {{ __('Votre nouveau mot de passe doit comporter plus de 8 caractères.') }}
                        </p>
                    </div>

                    <div class="block">
                        <x-label for="password_confirmation">{{ __('Confirmer nouveau mot de passe') }}</x-label>
                        <x-password id="password_confirmation" class="block mt-1 w-full" name="password_confirmation" required />
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <x-button type="submit" class="inline-flex">
                        {{ __('Enregistrer') }}
                    </x-button>
                </div>
            </div>
        </form>
        <div class="mt-5 space-y-8 divide-y divide-skin-base sm:mt-0 sm:col-span-2 sm:space-y-5">
            <div>
                <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                    {{ __('Appareils connectés') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                    {{ __('Nous vous avertirons via :email en cas d\'activité inhabituelle sur votre compte.', ['email' => Auth::user()->email]) }}
                </p>
            </div>
            <ul role="list" class="pt-2 divide-y divide-skin-base">
                @foreach($sessions->take(7) as $session)
                    <li class="py-4">
                        <div class="flex space-x-3">
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-skin-muted">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-skin-muted">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-sm font-medium font-sans text-skin-inverted">
                                        {{ $session->agent->browser() }} sur  {{ $session->agent->platform() }}
                                    </h3>
                                    @if ($session->is_current_device)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ __('Connecté') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-skin-base font-sans">
                                    @if($session->location)
                                        {{ $session->location->cityName }}, {{ $session->location->countryName }} • <time datetime="{{ $session->last_active }}">{{ $session->last_active }}</time>
                                    @else
                                        {{ __('Impossible de localiser cette position.') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</x-settings-layout>
