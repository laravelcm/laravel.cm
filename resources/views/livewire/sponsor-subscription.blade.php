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
                'bg-primary-500 text-white hover:!bg-primary-500 border-transparent' => $option === 'monthly',
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
                'bg-primary-500 text-white hover:!bg-primary-500 border-transparent' => $option === 'one-time',
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
                    <x-input name="amount" type="number" id="amount" wire:model="amount" required inline-addon="XAF" />
                    <x-default-button wire:click="subscribe" class="ml-4">
                        <x-loader wire:loading class="text-white" wire:target="subscribe" />
                        {{ __('Choisir') }}
                    </x-default-button>
                </dt>
                <dd class="mt-1.5 text-sm leading-5 text-skin-base">
                    {{ __("Choisissez un montant personnalisé. Aucune récompense n'est associée à ce parrainage.") }}
                </dd>
            </div>
        @endif
    </div>
</div>
