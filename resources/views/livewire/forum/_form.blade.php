<div class="pt-6 sm:pt-5 space-y-6 sm:space-y-5">

    <x-validation-errors />

    <div class="block">
        <x-label for="title">{{ __('Titre') }}</x-label>
        <x-input id="title" class="block mt-1 w-full" wire:model="title" name="title" required />
        <p class="mt-2 text-sm text-skin-base font-normal">Maximum de 75 caractères.</p>
    </div>

    <div class="block standard relative z-50" wire:ignore>
        <x-label for="channels_selected">Channels</x-label>
        <x-forms.select wire:model="channels_selected" id="channels_selected" class="mt-2" x-data="{}" x-init="function () { choices($el) }" multiple>
            @foreach($channels as $channel)
                <option value="{{ $channel->id }}" @if(in_array($channel->id, $channels_selected)) selected @endif>{{ $channel->name }}</option>
            @endforeach
        </x-forms.select>
    </div>

    <div class="block space-y-2">
        <x-label for="body">{{ __('Votre contenu') }}</x-label>
        <livewire:markdown-x :content="$body" :style="[
            'textarea' => 'w-full h-full border border-skin-input focus:border-skin-base focus:outline-none p-4 rounded-b-lg',
            'height' => 'h-[350px]',
        ]" />
        <p class="text-sm leading-5 font-normal text-skin-base">Pour le formatage du code (couleur syntaxique, langage, etc) nous utilisons <a href="https://torchlight.dev/docs/overview" target="_blank" class="underline font-medium text-skin-primary hover:text-skin-primary-hover">Torchlight</a>.</p>
    </div>

    <div class="pt-5 border-t border-skin-base">
        <div class="flex justify-end">
            <x-button type="button" class="inline-flex" wire:click="store">
                <x-loader class="text-white" wire:loading wire:target="store" />
                Enregistrer
            </x-button>
        </div>
    </div>
</div>
