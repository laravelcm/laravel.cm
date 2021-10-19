<x-settings-layout>

    <div class="sm:grid sm:grid-cols-5 sm:gap-12">
        <form class="sm:col-span-3 space-y-8 divide-y divide-skin-base" method="POST" action="{{ route('user.password.update') }}">
            <x-status-message />

            <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
                <div>
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                        Mot de passe
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                        Vous devez renseignez votre mot de passe actuel pour changer de mot de passe.
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
                        <p class="mt-2 text-sm text-skin-muted font-normal">Votre nouveau mot de passe doit comporter plus de 8 caractères.</p>
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
                        Enregistrer
                    </x-button>
                </div>
            </div>
        </form>
        <div class="mt-5 space-y-8 divide-y divide-skin-base sm:mt-0 sm:col-span-2 sm:space-y-5">
            <div>
                <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                    Appareils connectés
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                    Nous vous avertirons via {{ Auth::user()->email }} en cas d'activité inhabituelle sur votre compte.
                </p>
            </div>
            <ul role="list" class="pt-2 divide-y divide-skin-base">
                @foreach($sessions->take(7) as $session)
                    <li class="py-4">
                        <div class="flex space-x-3">
                            @if ($session->agent->isDesktop())
                                <x-heroicon-o-desktop-computer class="w-6 h-6 text-skin-muted" />
                            @else
                                <x-heroicon-o-device-mobile class="w-6 h-6 text-skin-muted" />
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
                                            Connecté
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
