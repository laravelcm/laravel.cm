<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-heroicon-o-exclamation class="h-6 w-6 text-red-600" />
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-skin-inverted font-sans" id="modal-headline">
                    {{ __('Supprimer cet article') }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm leading-5 text-skin-base font-normal">
                        {{ __('Voulez-vous vraiment cet article? Cette action est irréversible.') }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-danger-button wire:click="delete" type="button">
                <x-loader class="text-white" wire:loading wire:target="delete" />
                {{ __('Confirmer') }}
            </x-danger-button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-default-button wire:click="$emit('closeModal')" type="button">
                {{ __('Annuler') }}
            </x-default-button>
        </span>
    </x-slot>
</x-modal>
