<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium leading-6 text-skin-inverted">
            {{ __('Choisir une option') }}
        </h3>
        <span class="isolate inline-flex rounded-md shadow-sm">
          <x-default-button
              type="button"
              @class([
                'relative text-sm leading-5 inline-flex items-center rounded-r-none px-2.5 py-2 !ring-0 focus:z-10',
                '!bg-primary-500 text-white hover:!bg-primary-500 border-transparent' => $option === 'monthly',
                '!bg-skin-body hover:!bg-skin-card' => $option !== 'monthly'
              ])
              wire:click="chooseOption('monthly')"
          >
              {{ __('Mensuel') }}
          </x-default-button>
          <x-default-button
              type="button"
              @class([
                'relative text-sm leading-5 -ml-px inline-flex items-center rounded-l-none px-2.5 py-2 !ring-0 focus:z-10',
                '!bg-primary-500 text-white hover:!bg-primary-500 border-transparent' => $option === 'one-time',
                '!bg-skin-body hover:!bg-skin-card' => $option !== 'one-time'
             ])
              wire:click="chooseOption('one-time')"
          >
              {{ __('Une fois') }}
          </x-default-button>
        </span>
    </div>
    <div class="overflow-hidden border border-skin-base rounded-md bg-skin-card">
        @if($option === 'monthly')
            <div class="p-4 flex items-start">
                <x-heroicon-o-exclamation class="w-10 h-10 text-yellow-400" />
                <p class="ml-4 text-base leading-6 text-skin-base">
                    {{ __('Les choix pour cette option ne sont pas encore disponible.') }}
                </p>
            </div>
        @else
            <div class="hover:bg-skin-card-muted p-4">
                <dt class="flex items-center">
                    <div class="relative flex items-center">
                        <input
                            aria-label="{{ __('Montant') }}"
                            name="amount"
                            wire:model.defer="amount"
                            class="bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green block w-full placeholder-skin-input focus:outline-none focus:placeholder-skin-input-focus text-skin-base sm:text-sm border-skin-input rounded-md pr-16"
                            type="number"
                            required
                        />
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <label for="currency" class="sr-only">{{ __('Devise') }}</label>
                            <select wire:model="currency" id="currency" name="currency" class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-skin-base focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm">
                                <option value="XAF">XAF</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <x-default-button wire:click="subscribe" class="ml-4">
                        <x-loader wire:loading class="text-white" wire:target="subscribe" />
                        {{ __('Choisir') }}
                    </x-default-button>
                </dt>
                @error('amount')
                    <p class="mt-2 text-sm text-red-500">{{ __('Votre montant est requis') }}</p>
                @enderror
                <dd class="mt-1.5 text-sm leading-5 text-skin-base">
                    {{ __("Choisissez un montant personnalisé. Aucune récompense n'est associée à ce parrainage.") }}
                </dd>
            </div>
        @endif
    </div>
</div>
