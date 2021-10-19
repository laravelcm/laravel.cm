<x-settings-layout>

    <div class="sm:grid sm:grid-cols-3 sm:gap-12">
        <form class="sm:col-span-2 space-y-8 divide-y divide-skin-base" method="POST" action="{{ route('user.password.update') }}">
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
        <div class="sm:col-span-1">
            Bonjour
        </div>
    </div>

</x-settings-layout>
