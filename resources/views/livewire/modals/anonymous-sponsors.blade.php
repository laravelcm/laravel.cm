<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content">
        <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
            Vous êtes sur le point de soutenir Laravel Cameroun pour la somme de
            <span class="font-bold text-gray-900">{{ $amount }} F.CFA</span>
            . Nous vous remercions pour votre don.
        </p>
        <div class="mt-3 grid gap-4 lg:mt-5 lg:grid-cols-2 lg:gap-6">
            <div>
                <label for="name">Nom complet</label>
                <input container-class="mt-1" name="name" id="name" wire:model="name" />
            </div>
            <div>
                <label for="email">Adresse E-mail</label>
                <input
                    container-class="mt-1"
                    name="email"
                    id="email"
                    wire:model="email"
                    placeholder="arthur@laravel.cm"
                />
            </div>
        </div>
        <div class="mt-4 border-t border-skin-base pt-5">
            <h5 class="font-medium text-gray-700 dark:text-gray-300">Vous êtes ?</h5>
            <div class="mt-2 flex items-center space-x-5">
                <div class="flex items-center gap-x-3">
                    <input
                        id="company"
                        name="type"
                        wire:model="type"
                        value="company"
                        type="radio"
                        class="size-4 border-skin-input text-primary-600 focus:ring-primary-600"
                    />
                    <label for="company" class="block text-sm font-medium leading-6 text-gray-900">
                        Entreprise
                    </label>
                </div>
                <div class="flex items-center gap-x-3">
                    <input
                        id="developer"
                        name="type"
                        wire:model="type"
                        value="developer"
                        type="radio"
                        class="size-4 border-skin-input text-primary-600 focus:ring-primary-600"
                    />
                    <label for="developer" class="block text-sm font-medium leading-6 text-gray-900">
                        Développeur / Sympathisant
                    </label>
                </div>
            </div>
            <div class="mt-1.5">
                <label for="url">
                    {{ $type === 'company' ? 'Lien vers le logo de votre entreprise' : 'Lien vers une photo de vous' }}
                </label>
                <input container-class="mt-1" name="url" id="url" wire:model="url" inline-addon="https://" />
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-buttons.primary wire:click="submit" type="button">
                <x-loader class="text-white" wire:loading wire:target="submit" />
                Valider
            </x-buttons.primary>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-buttons.default wire:click="$dispatch('closeModal')" type="button">Annuler</x-buttons.default>
        </span>
    </x-slot>
</x-modal>
