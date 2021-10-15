<x-settings-layout>

    <form class="space-y-8 divide-y divide-skin-base" method="POST" action="{{ route('user.settings.update') }}">
        <x-validation-errors />
        <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
            <div>
                @csrf
                @method('PUT')
                <div>
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                        Profil
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                        Vous trouverez ci-dessous les informations de votre profil pour votre compte.
                    </p>
                </div>
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="username" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Pseudo
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-skin-input bg-skin-card text-skin-base sm:text-sm">
                                    laravel.cm/user/
                                </span>
                                <input type="text" name="username" id="username" autocomplete="username" class="bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green flex-1 block w-full focus:outline-none focus:placeholder-skin-input-focus font-normal text-skin-base sm:text-sm border-skin-input min-w-0 rounded-none rounded-r-md" />
                            </div>
                        </div>
                   </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="about" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Bio
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-textarea id="about" name="bio" rows="3" class="max-w-lg" />
                            <p class="mt-2 text-sm text-skin-muted font-normal">Écrivez quelques phrases sur vous-même.</p>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-skin-base sm:pt-5">
                        <div>
                            <label for="photo" class="block text-sm font-medium text-skin-inverted-muted">
                                Photo
                            </label>
                            <p class="hidden sm:block text-skin-muted text-sm font-normal">Celle-ci sera affiché sur votre profil.</p>
                        </div>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg w-full">
                                <x-media-library-attachment
                                    name="avatar"
                                    rules="mimes:png,jpg,jpeg|max:1024"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="website" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Votre site web
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <x-input id="website" name="website" type="text" autocomplete="email" class="block max-w-lg w-full" placeholder="https://www.example.com" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                        Informations personnelles
                    </h3>
                    <p class="mt-1 text-sm text-skin-base font-normal">
                        Mettez à jour vos informations personnelles. Votre adresse ne sera jamais accessible au public.
                    </p>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Nom
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 relative">
                            <x-input type="text" name="name" id="name" autocomplete="given-name" class="max-w-lg"/>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="location" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Localisation
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 relative">
                            <x-input id="location" name="location" type="text" autocomplete="email" class="block max-w-lg" />
                        </div>
                    </div>

                    <div x-data="internationalNumber('#phone_number')" class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="phone_number" class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Numéro de téléphone
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 relative">
                            <x-input type="tel" name="phone_number" id="phone_number" class="block max-w-lg pl-10" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-skin-base pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                        Réseaux sociaux
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                        Faites savoir à tout le monde où ils peuvent vous trouver.
                    </p>
                </div>
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
                        <label class="block text-sm font-medium text-skin-inverted-muted sm:mt-px sm:pt-2">
                            Entrez votre pseudo Twitter sans le symbole @ en tête.
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 space-y-4">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-skin-input bg-skin-card text-skin-base sm:text-sm">
                                    twitter.com/
                                </span>
                                <input type="text" name="twitter_profile" id="twitter_profile" aria-label="Profil Twitter" class="bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green flex-1 block w-full focus:outline-none focus:placeholder-skin-input-focus font-normal text-skin-base sm:text-sm border-skin-input min-w-0 rounded-none rounded-r-md" />
                            </div>
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-skin-input bg-skin-card text-skin-base sm:text-sm">
                                    github.com/
                                </span>
                                <input type="text" name="github_profile" id="github_profile" aria-label="Profil Github" class="bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green flex-1 block w-full focus:outline-none focus:placeholder-skin-input-focus font-normal text-skin-base sm:text-sm border-skin-input min-w-0 rounded-none rounded-r-md" />
                            </div>
                        </div>
                    </div>
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

</x-settings-layout>

