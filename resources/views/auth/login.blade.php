<x-app-layout title="Se connecter">
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900">
                    Se connecter à son compte
                </h2>
            </div>
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4 rounded-lg">
                    <div>
                        <label for="email-address" class="sr-only">Adresse E-mail</label>
                        <x-email
                            id="email-address"
                            name="email"
                            autocomplete="email"
                            required
                            placeholder="Adresse E-mail"
                        />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Mot de passe</label>
                        <x-password
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            placeholder="Mot de passe"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            name="remember_me"
                            type="checkbox"
                            class="size-4 rounded border-gray-300 bg-white text-green-600 focus:ring-green-500"
                        />
                        <label for="remember_me" class="ml-2 block cursor-pointer text-sm text-gray-500 dark:text-gray-400">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <x-link
                            href="{{ route('password.request') }}"
                            class="font-medium text-green-600 hover:text-green-500"
                        >
                            Mot de passe oublié ?
                        </x-link>
                    </div>
                </div>

                <div>
                    <x-buttons.primary type="submit" class="group relative w-full">
                        <span class="absolute pointer-events-none inset-y-0 left-0 flex items-center pl-3">
                            <x-heroicon-s-lock-closed class="size-5 text-green-500 group-hover:text-green-400" />
                        </span>
                        Se connecter
                    </x-buttons.primary>
                </div>
            </form>

            @include('partials._socials-link')
        </div>
    </div>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</x-app-layout>
