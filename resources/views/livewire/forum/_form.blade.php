<div class="space-y-6 pt-6 sm:space-y-5 sm:pt-5">
    <x-validation-errors />

    <div class="block">
        <x-label for="title">Titre</x-label>
        <x-input id="title" class="mt-1 block w-full" wire:model="title" name="title" required />
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Maximum de 75 caractères.</p>
    </div>

    <div class="standard relative z-50 block" wire:ignore>
        <x-label for="channels_selected">Channels</x-label>
        <x-forms.select
            wire:model="channels_selected"
            id="channels_selected"
            class="mt-2"
            x-data="{}"
            x-init="function () { choices($el) }"
            multiple
        >
            @foreach ($channels as $channel)
                <option value="{{ $channel->id }}" @selected(in_array($channel->id, $channels_selected))>
                    {{ $channel->name }}
                </option>
            @endforeach
        </x-forms.select>
    </div>

    <div class="block space-y-2">
        <x-label for="body">Votre contenu</x-label>
        <livewire:markdown-x
            :content="$body"
            :style="[
            'textarea' => 'w-full h-full border border-skin-input focus:border-skin-base focus:outline-none p-4 rounded-b-lg',
            'height' => 'h-[350px]',
        ]"
        />
        <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
            Pour le formatage du code (couleur syntaxique, langage, etc) nous utilisons
            <a
                href="https://torchlight.dev/docs/overview"
                target="_blank"
                class="font-medium text-primary-600 underline hover:text-primary-600-hover"
            >
                Torchlight
            </a>
            .
        </p>
    </div>

    <div class="border-t border-skin-base pt-5">
        <div class="flex justify-end">
            <x-buttons.primary type="button" class="inline-flex" wire:click="store">
                <x-loader class="text-white" wire:loading wire:target="store" />
                Enregistrer
            </x-buttons.primary>
        </div>
    </div>
</div>
