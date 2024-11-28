<div>
    @php
        use Filament\Forms\Components\Textarea;
    @endphp

    <x-settings-layout  xmlns:x-filament="http://www.w3.org/1999/html">
    <x-validation-errors />

    <x-status-message class="mb-8" />

    <form class="space-y-8 divide-y divide-skin-base" method="POST" action="{{ route('user.settings.update') }}">
        <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
            <div>
                @csrf
                @method('PUT')
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ __('Profil') }}
                    </h3>
                    <p class="max-w-2xl mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ __('Vous trouverez ci-dessous les informations de votre profil pour votre compte.') }}
                    </p>
                </div>
                <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="username" class="text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2">
                            {{ __('Pseudo') }}
                        </label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg rounded-md shadow-sm">
                                <x-filament::input
                                    type="text"
                                    name="username"
                                    id="username"
                                    autocomplete="username"
                                    leading-addon="laravel.cm/user/"
                                    wire.model=""
                                    container-class="flex-1"
                                    container-input-class="flex"
                                    :value="Auth::user()->username"
                                    required="true"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="about" class="text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2">
                            {{ __('Bio') }}
                        </label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            {{ $this->form }}
                            <p class="mt-2 text-sm font-normal text-skin-muted">
                                {{ __('Écrivez quelques phrases sur vous-même.') }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5"
                    >
                        <div class="sm:mt-px sm:pt-2">
                            <label  class="text-gray-700 dark:text-gray-300">{{ __('Photo') }} </label>
                                <p class="hidden text-sm font-normal text-skin-muted sm:block">
                                {{ __('Celle-ci sera affiché sur votre profil.') }}
                            </p>
                        </div>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <div class="w-full max-w-lg">
                                <input type="file" name="avatar" class="filepond" data-max-file-size="1MB" />
                            </div>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label
                            for="website"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2"
                        >
                            {{ __('Votre site web') }}
                        </label>
                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                            <x-filament::input
                                id="website"
                                name="website"
                                type="url"
                                autocomplete="email"
                                container-input-class="w-full max-w-lg"
                                placeholder="https://www.example.com"
                                :value="Auth::user()->website"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 space-y-6 sm:space-y-5 sm:pt-10">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ __('Informations personnelles') }}
                    </h3>
                    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ __('Mettez à jour vos informations personnelles. Votre adresse ne sera jamais accessible au public.') }}
                    </p>
                </div>
                <div class="space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2">
                            {{ __('Nom') }}
                        </label>
                        <div class="relative mt-1 sm:col-span-2 sm:mt-0">
                            <x-filament::input
                                type="text"
                                name="name"
                                id="name"
                                container-input-class="w-full max-w-lg"
                                :value="Auth::user()->name"
                                required
                            />
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2">
                            {{ __('Adresse E-mail') }}
                        </label>
                        <div class="relative mt-1 sm:col-span-2 sm:mt-0">
                            <div class="flex items-center space-x-3">
                                <x-filament::input
                                    name="email"
                                    id="email"
                                    container-class="flex-1"
                                    container-input-class="max-w-lg"
                                    required
                                    :value="Auth::user()->email"
                                />

                                @unless (Auth::user()->hasVerifiedEmail())
                                    <x-untitledui-alert-triangle class="text-yellow-500 size-6" />
                                @endunless
                            </div>
                            @unless (Auth::user()->hasVerifiedEmail())
                                <p class="mt-2 font-sans text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Cette adresse mail n\'est pas vérifiée.') }}

                                    <a
                                        href="{{ route('verification.notice') }}"
                                        class="underline text-primary-600 hover:text-primary-600-hover"
                                    >
                                        {{ __('Renvoyer l\'e-mail de vérification.') }}
                                    </a>
                                </p>
                            @endunless
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label
                            for="location"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2"
                        >
                            {{ __('Localisation') }}
                        </label>
                        <div class="relative mt-1 sm:col-span-2 sm:mt-0">
                            <x-filament::input
                                id="location"
                                name="location"
                                type="text"
                                autocomplete="email"
                                container-input-class="max-w-lg"
                                :value="Auth::user()->location"
                            />
                        </div>
                    </div>

                    <div
                        x-data="internationalNumber('#phone_number')"
                        class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5"
                    >
                        <label
                            for="phone_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2"
                        >
                            {{ __('Numéro de téléphone') }}
                        </label>
                        <div class="relative mt-1 sm:col-span-2 sm:mt-0">
                            <x-filament::input
                                type="tel"
                                name="phone_number"
                                id="phone_number"
                                container-input-class="block max-w-lg"
                                :value="Auth::user()->phone_number"
                                isPhone
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 space-y-6 sm:space-y-5 sm:pt-10">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ __('Réseaux sociaux') }}
                    </h3>
                    <p class="max-w-2xl mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ __('Faites savoir à tout le monde où ils peuvent vous trouver.') }}
                    </p>
                </div>
                <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-skin-base sm:pt-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 sm:mt-px sm:pt-2">
                            {{ __('Entrez votre pseudo Twitter sans le symbole @ en tête.') }}
                        </label>
                        <div class="mt-1 space-y-4 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-lg">
                                <x-filament::input
                                    type="text"
                                    name="twitter_profile"
                                    id="twitter_profile"
                                    aria-label="Profil Twitter"
                                    leading-addon="twitter.com/"
                                    container-class="flex-1"
                                    container-input-class="flex"
                                    :value="Auth::user()->twitter()"
                                />
                            </div>
                            <div class="flex max-w-lg">
                                <x-filament::input
                                    type="text"
                                    name="github_profile"
                                    id="github_profile"
                                    aria-label="Profil Github"
                                    leading-addon="github.com/"
                                    container-class="flex-1"
                                    container-input-class="flex"
                                    :value="Auth::user()->githubUsername()"
                                />
                            </div>
                            <div class="flex max-w-lg">
                                <x-filament::input
                                    type="text"
                                    name="linkedin_profile"
                                    id="linkedin_profile"
                                    aria-label="Profil LinkedIn"
                                    leading-addon="linkedin.com/in/"
                                    container-class="flex-1"
                                    container-input-class="flex"
                                    :value="Auth::user()->linkedin()"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <x-buttons.primary type="submit" class="inline-flex">
                    {{ __('Enregistrer') }}
                </x-buttons.primary>
            </div>
        </div>
    </form>
</x-settings-layout>
</div>
