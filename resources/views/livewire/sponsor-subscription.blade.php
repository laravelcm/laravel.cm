<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium leading-6 text-skin-inverted">Choisir une option</h3>
        <span class="isolate inline-flex rounded-md shadow-sm">
            <x-default-button
                type="button"
                @class([
                    'relative text-sm leading-5 inline-flex items-center rounded-r-none px-2.5 py-2 ring-0 focus:z-10',
                    'bg-primary-500 text-white hover:bg-primary-500 border-transparent' => $option === 'monthly',
                    'bg-skin-body hover:bg-skin-card' => $option !== 'monthly',
                ])
                wire:click="chooseOption('monthly')"
            >
                Mensuel
            </x-default-button>
            <x-default-button
                type="button"
                @class([
                    'relative text-sm leading-5 -ml-px inline-flex items-center rounded-l-none px-2.5 py-2 ring-0 focus:z-10',
                    'bg-primary-500 text-white hover:bg-primary-500 border-transparent' => $option === 'one-time',
                    'bg-skin-body hover:bg-skin-card' => $option !== 'one-time',
                ])
                wire:click="chooseOption('one-time')"
            >
                Une fois
            </x-default-button>
        </span>
    </div>
    <div class="overflow-hidden rounded-md border border-skin-base bg-skin-card">
        @if ($option === 'monthly')
            <div class="flex items-start p-4">
                <x-untitledui-alert-triangle class="h-10 w-10 text-yellow-400" />
                <p class="ml-4 text-base leading-6 text-skin-base">
                    Les choix pour cette option ne sont pas encore disponible.
                </p>
            </div>
        @else
            <div class="p-4 hover:bg-skin-card-muted">
                <dt class="flex items-center">
                    <div class="relative flex items-center">
                        <input
                            aria-label="Montant"
                            name="amount"
                            wire:model="amount"
                            class="block w-full rounded-md border-skin-input bg-skin-input pr-16 text-skin-base placeholder-skin-input shadow-sm focus:border-flag-green focus:placeholder-skin-input-focus focus:outline-none focus:ring-flag-green sm:text-sm"
                            type="number"
                            required
                        />
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <label for="currency" class="sr-only">Devise</label>
                            <select
                                wire:model="currency"
                                id="currency"
                                name="currency"
                                class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-skin-base focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm"
                            >
                                <option value="XAF">XAF</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <x-default-button wire:click="subscribe" class="ml-4">
                        <x-loader wire:loading class="text-white" wire:target="subscribe" />
                        Choisir
                    </x-default-button>
                </dt>
                @error('amount')
                    <p class="mt-2 text-sm text-red-500">Votre montant est requis.</p>
                @enderror

                <dd class="mt-1.5 text-sm leading-5 text-skin-base">
                    Choisissez un montant personnalisé. Aucune récompense n'est associée à ce parrainage.
                </dd>
            </div>
        @endif
    </div>
</div>
