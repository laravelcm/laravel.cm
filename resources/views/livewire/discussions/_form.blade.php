<div class="space-y-6 pt-6 sm:space-y-5 sm:pt-5">
    <x-validation-errors />

    <div class="block">
        <x-label for="title">Titre</x-label>
        <x-input id="title" class="mt-1 block w-full" wire:model="title" name="title" required />
        <p class="mt-2 text-sm text-skin-base">Maximum de 160 caractères.</p>
    </div>

    <div class="standard relative z-50 block" wire:ignore>
        <x-label for="channels_selected">Tags</x-label>
        <x-forms.select
            wire:model="tags_selected"
            id="tags_selected"
            class="mt-2"
            x-data="{}"
            x-init="function () { choices($el) }"
            multiple
        >
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected(in_array($tag->id, $tags_selected))>
                    {{ $tag->name }}
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
            'height' => 'h-[450px]',
        ]"
        />
    </div>

    <div class="border-t border-skin-base pt-5">
        <div class="flex justify-end">
            <x-button type="button" class="inline-flex" wire:click="store">
                <x-loader class="text-white" wire:loading wire:target="store" />
                Enregistrer
            </x-button>
        </div>
    </div>
</div>
