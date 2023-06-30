<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content">
        <p class="text-sm leading-5 text-skin-base">
            {!! __("Vous êtes sur le point de soutenir Laravel Cameroun pour la somme de <span class='font-bold text-skin-inverted'>:amount F.CFA</span>. Nous vous remercions pour votre don.", ['amount' => $amount]) !!}
        </p>
        <div class="mt-3 grid gap-4 lg:grid-cols-2 lg:gap-6 lg:mt-5">
            <div>
                <x-label for="name">{{ __('Nom complet') }}</x-label>
                <x-input container-class="mt-1" name="name" id="name" wire:model.defer="name" />
            </div>
            <div>
                <x-label for="email">{{ __('Adresse E-mail') }}</x-label>
                <x-email container-class="mt-1" name="email" id="email" wire:model.defer="email" placeholder="etoo@laravel.cm" />
            </div>
        </div>
        <div class="mt-4 pt-5 border-t border-skin-base">
            <h5 class="text-skin-inverted-muted font-medium">{{ __('Vous êtes ?') }}</h5>
            <div class="mt-2 flex items-center space-x-5">
                <div class="flex items-center gap-x-3">
                    <input id="company" name="type" wire:model.defer="type" value="company" type="radio" class="h-4 w-4 border-skin-input text-primary-600 focus:ring-primary-600">
                    <label for="company" class="block text-sm font-medium leading-6 text-skin-inverted">{{ __('Entreprise') }}</label>
                </div>
                <div class="flex items-center gap-x-3">
                    <input id="developer" name="type" wire:model.defer="type" value="developer" type="radio" class="h-4 w-4 border-skin-input text-primary-600 focus:ring-primary-600">
                    <label for="developer" class="block text-sm font-medium leading-6 text-skin-inverted">{{ __('Développeur / Sympathisant') }}</label>
                </div>
            </div>
            <div class="mt-1.5">
                <x-label for="url">
                    {{ $type === 'company' ? __('Lien vers le logo de votre entreprise') : __('Lien vers une photo de vous') }}
                </x-label>
                <x-input container-class="mt-1" name="url" id="url" wire:model.defer="url" inline-addon="https://" />
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-button wire:click="submit" type="button">
                <x-loader class="text-white" wire:loading wire:target="submit" />
                {{ __('Valider') }}
            </x-button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-default-button wire:click="$emit('closeModal')" type="button">
                {{ __('Annuler') }}
            </x-default-button>
        </span>
    </x-slot>
</x-modal>
