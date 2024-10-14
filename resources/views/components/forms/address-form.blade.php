<x-modal
    header-classes="p-4 border-b border-gray-100 sm:px-6 sm:py-4"
    content-classes="relative p-4 flex-1 sm:max-h-[500px] sm:px-6 sm:px-5"
    footer-classes="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
    form-action="save"
>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="space-y-4 pb-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-forms.label for="first_name" :value="__('First name')" required />
                <x-forms.input wire:model="first_name" id="first_name" name="first_name" type="text"/>
                <x-forms.errors :messages="$errors->get('first_name')" />
            </div>

            <div class="space-y-2">
                <x-forms.label for="last_name" :value="__('Last name')" required />
                <x-forms.input wire:model="last_name" id="last_name" name="last_name" type="text"/>
                <x-forms.errors :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="space-y-2">
            <x-forms.label for="street_address" :value="__('Street Address')" required />
            <x-forms.input
                wire:model="street_address"
                id="street_address"
                placeholder="Akwa Avenue 34"
                class="w-full"
                name="street_address"
                type="text"
            />
            <x-forms.errors :messages="$errors->get('street_address')" />
        </div>

        <div class="space-y-2">
            <x-forms.label for="street_address_plus" :value="__('Apartment, suite, etc.')" />
            <x-forms.input
                wire:model="street_address_plus"
                class="w-full"
                id="street_address_plus"
                name="street_address_plus"
                type="text"
            />
            <x-forms.errors :messages="$errors->get('street_address_plus')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-forms.label for="city" :value="__('City')" required/>
                <x-forms.input wire:model="city" id="city" name="city" type="text" />
                <x-forms.errors :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-forms.label for="postal_code" :value="__('Postal / Zip code')" required />
                <x-forms.input wire:model="postal_code" id="postal_code" name="postal_code" type="text"/>
                <x-forms.errors :messages="$errors->get('postal_code')" class="mt-2" />
            </div>

        </div>

        <div class="space-y-2">
            <x-forms.label for="country_id" :value="__('Country')" required />
            <x-forms.select wire:model="country_id" id="country_id" class="w-full">
                @foreach ($countries as $key => $country)
                    <option value="{{ $key }}">{{ $country }}</option>
                @endforeach
            </x-forms.select>
            <x-forms.errors :messages="$errors->get('country_id')" />
        </div>

        <div class="space-y-2">
            <x-forms.label for="phone_number" :value="__('Phone Number')" />
            <x-forms.input wire:model="phone_number" class="w-full" id="phone_number" name="phone_number" type="text" />
            <x-forms.errors :messages="$errors->get('phone_number')" />
        </div>

        <div class="grid gap-y-2 sm:grid-cols-3 sm:gap-x-4 sm:items-start">
            <div class="flex items-center justify-between gap-x-3 ">
                <x-forms.label for="adress_type" :value="__('Address type')" />
            </div>

            <div class="grid auto-cols-fr gap-y-2 sm:col-span-2">
                <div class="columns-[--cols-default] fi-fo-radio gap-4 flex flex-wrap">
                    <div>
                        <x-forms.label class="flex items-center gap-3">
                            <x-forms.radio id="type-billing" name="type" value="billing" wire:model="type"/>
                            {{ __('Billing address') }}
                        </x-forms.label>
                    </div>

                    <div>
                        <x-forms.label class="flex items-center gap-3">
                            <x-forms.radio id="type-shipping" name="type" value="shipping" wire:model="type"/>
                            {{ __('Shipping address') }}
                        </x-forms.label>
                    </div>
                </div>
            </div>
            <x-forms.errors :messages="$errors->get('type')" class="mt-2" />
        </div>
    </div>

    <x-slot name="buttons">
        <x-buttons.submit
            :title="__('shopper::forms.actions.save')"
            wire:loading.attr="data-loading"
            class="w-full sm:ml-3 sm:w-auto"
        />
        <x-buttons.default
            type="button"
            wire:click="$dispatch('closeModal')"
            class="w-full px-4 py-2 mt-3 text-sm sm:mt-0 sm:w-auto"
        >
            {{ __('shopper::forms.actions.cancel') }}
        </x-buttons.default>
    </x-slot>
</x-modal>
