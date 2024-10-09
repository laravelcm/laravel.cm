<x-app-layout title="Réinitialiser votre mot de passe">
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">
            <div>
                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 sm:text-left">
                    Réinitialiser votre mot de passe
                </h2>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                <div class="block">
                    <x-label for="email">Adresse E-mail</x-label>
                    <x-email
                        id="email"
                        class="mt-1 block w-full"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required
                        autofocus
                    />
                </div>

                <div class="block">
                    <x-label for="email">Mot de passe</x-label>
                    <x-password
                        id="password"
                        class="mt-1 block w-full"
                        name="password"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <div class="block">
                    <x-label for="email">Confirmer Mot de passe</x-label>
                    <x-password
                        id="password_confirmation"
                        class="mt-1 block w-full"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-button>Réinitialiser mot de passe</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
