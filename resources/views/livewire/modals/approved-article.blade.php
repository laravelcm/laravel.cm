<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content">
        <div class="sm:flex sm:items-start">
            <div
                class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
            >
                <x-untitledui-alert-triangle class="size-6 text-red-600" />
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="font-heading text-lg font-medium leading-6 text-gray-900" id="modal-headline">
                    Approuver cet article
                </h3>
                <div class="mt-2">
                    <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                        Voulez-vous cet article ? Il paraitra dans la liste des articles et un mail sera envoyé à
                        l'auteur pour lui signaler.
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-buttons.primary wire:click="approved" type="button">
                <x-loader class="text-white" wire:loading wire:target="approved" />
                Approuver
            </x-buttons.primary>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-buttons.default wire:click="$dispatch('closeModal')" type="button">Annuler</x-buttons.default>
        </span>
    </x-slot>
</x-modal>
