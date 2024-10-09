<x-app-layout title="Réinitialisation du mot de passe">
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">
            <div>
                <x-status-message class="mb-5" />

                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 sm:text-left">
                    Réinitialisation du mot de passe
                </h2>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    Mot de passe oublié ? Aucun problème. Communiquez-nous simplement votre adresse e-mail et nous vous
                    enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un
                    nouveau.
                </div>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="mt-8">
                @csrf

                <div class="block">
                    <x-label for="email">{{ __('Email') }}</x-label>
                    <x-email
                        id="email"
                        class="mt-1 block w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                    />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-button type="submit" class="relative w-full">Réinitialisation du mot de passe</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
