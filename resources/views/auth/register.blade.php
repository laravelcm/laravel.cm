<x-app-layout title="Créer un compte">
    <div class="mx-auto flex w-full items-center justify-between py-6 sm:max-w-4xl sm:py-9">
        <div class="hidden lg:block lg:w-90">
            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                Ouvrez votre esprit pour découvrir de nouveaux horizons.
            </h3>
            <dl class="mt-6 space-y-4">
                <div class="relative">
                    <dt>
                        <x-icon.podcast class="absolute size-6" />
                    </dt>
                    <dd class="ml-9 mt-2 text-base text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-900">Podcast.</span>
                        <span>
                            Suivez des podcasts sur différentes thématiques avec des freelances, développeurs,
                            entrepreneurs etc.
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.discussion class="absolute size-6" />
                    </dt>
                    <dd class="ml-9 mt-2 text-base text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-900">Discussions.</span>
                        <span>Participez à des discussions et débats ouverts avec plusieurs autres participants.</span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.code-snippet class="absolute size-6" />
                    </dt>
                    <dd class="ml-9 mt-2 text-base text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-900">Code Snippets.</span>
                        <span>
                            Partagez des codes sources de différents langages pour venir en aide à d’autres
                            développeurs.
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <x-icon.premium class="absolute size-6" />
                    </dt>
                    <dd class="ml-9 mt-2 text-base text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-gray-900">Premium.</span>
                        <span>
                            Devenez premium, supporter la communauté et accéder à des contenus et codes sources privés.
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        <div class="mx-auto max-w-md space-y-8 lg:mx-0">
            <div class="space-y-3">
                <h2 class="font-heading text-3xl font-extrabold text-gray-900">Rejoindre Laravel Cameroun</h2>
                <x-profile-users />
                <p class="text-base leading-6 text-gray-500 dark:text-gray-400">
                    Rejoignez plus de 200 développeurs et designers. Parce qu’il ny’a pas que le code dans la vie.
                </p>
            </div>
            <div>
                <x-status-message />

                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <x-input
                            id="name"
                            name="name"
                            autocomplete="name"
                            placeholder="Nom complet"
                            aria-label="Nom complet"
                            required
                        />
                        <x-email
                            id="email"
                            name="email"
                            autocomplete="email"
                            required
                            placeholder="Adresse E-mail"
                            aria-label="Adresse E-mail"
                        />
                        <x-input
                            id="username"
                            name="username"
                            autocomplete="current-password"
                            required
                            placeholder="Pseudo"
                            aria-label="Pseudo"
                        />
                        <x-password
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            placeholder="Mot de passe (min. 6 caratères)"
                            aria-label="Mot de passe"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="opt_in"
                                name="opt_in"
                                type="checkbox"
                                class="size-4 rounded border-skin-input bg-skin-input text-green-600 focus:ring-green-500"
                            />
                            <label for="opt_in" class="ml-2 block text-sm font-normal text-gray-500 dark:text-gray-400">
                                Je veux recevoir la newsletter
                            </label>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-s-lock-closed class="size-5 text-green-500 group-hover:text-green-400" />
                            </span>
                            Créer mon compte
                        </button>
                    </div>
                </form>
            </div>

            @include('partials._socials-link')
        </div>
    </div>
</x-app-layout>
