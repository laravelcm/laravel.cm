<x-modal footerClasses="px-4 pb-5 sm:px-4 sm:flex sm:flex-row-reverse">
    <x-slot name="content" class="space-y-4">
        <div class="space-y-2">
            <x-forms.label for="raison" :value="__('Motif du rejet')"  required/>
            <x-forms.input wire:model="raison" id="raison" name="raison" type="text"/>
            <x-forms.errors :messages="$errors->get('raison')" />
        </div>
        <div class="space-y-2">
            <x-forms.label for='description' :value="__('Description')" required />
            <x-forms.textarea id='description' rows='4' wire:model='description' placeholder='Descrition du rejet' name="description"></x-forms.textarea>
            <x-forms.errors :messages="$errors->get('description')" />
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-danger-button wire:click="declined" type="button">
                <x-loader class="text-white" wire:loading wire:target="declined" />
                {{ __('Decliner') }}
            </x-danger-button>
        </span>
        <span class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-default-button wire:click="$emit('closeModal')" type="button">
                {{ __('Annuler') }}
            </x-default-button>
        </span>
    </x-slot>
</x-modal>
