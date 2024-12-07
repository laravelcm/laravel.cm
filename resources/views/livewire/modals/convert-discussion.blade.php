<x-modal
    header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 border-t border-gray-100 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
>
    <x-slot name="title">
        {{ __("Confirmez la convertion") }}
    </x-slot>

    <div class="space-y-4 pb-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-slot name="content">
                    {{ __("Voulez-vous vraiment convertir cette discussion en thread ?") }}
                </x-slot>
            </div>
        </div>
    </div>

    <x-slot name="buttons">
        <x-buttons.submit
            :title="__('Confirmer')"
            wire:loading.attr="data-loading"
            class="w-full sm:ml-3 sm:w-auto"
        />
        <x-buttons.default
            type="button"
            wire:click="$dispatch('closeModal')"
            class="w-full px-4 py-2 mt-3 text-sm sm:mt-0 sm:w-auto"
        >
            {{ __('Annuler') }}
        </x-buttons.default>
    </x-slot>
</x-modal>
