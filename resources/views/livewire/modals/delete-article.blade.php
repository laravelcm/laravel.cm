<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content">
        <div class="sm:flex sm:items-start">
            <div
                class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
            >
                <x-untitledui-alert-triangle class="h-6 w-6 text-red-600" />
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="font-heading text-lg font-medium leading-6 text-skin-inverted" id="modal-headline">
                    Supprimer cet article
                </h3>
                <p class="mt-2 text-sm leading-5 text-skin-base">
                    Voulez-vous vraiment cet article ? Cette action est irréversible.
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-danger-button wire:click="delete" type="button">
                <x-loader class="text-white" wire:loading wire:target="delete" />
                Confirmer
            </x-danger-button>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-default-button wire:click="$dispatch('closeModal')" type="button">Annuler</x-default-button>
        </span>
    </x-slot>
</x-modal>
