<div class="pt-5 mt-8 border-t border-skin-base">

    <h3 class="text-lg sm:text-xl font-sans text-skin-inverted font-medium mb-6">Laissez votre réponse</h3>

    <livewire:markdown-x :content="$body" :autofocus="false" key="create-reply" :style="[
        'textarea' => 'w-full h-full border border-skin-input focus:border-skin-base focus:outline-none p-4 rounded-b-lg',
        'height' => 'h-[250px]',
    ]" />

    @error('body')
        <p class="mt-2 text-sm text-red-500 leading-5 font-normal">{{ $message }}</p>
    @enderror

    <div class="flex justify-between items-start mt-4 gap-x-8 lg:items-center">
        <p class="font-normal text-skin-base">
            Assurez-vous d'avoir lu nos <a href="{{ route('rules') }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">règles de conduite</a> avant de répondre a ce thread.
        </p>
    </div>

    <div class="mt-5">
        <div class="flex justify-end">
            <x-button type="button" class="inline-flex" wire:click="save">
                <x-loader class="text-white" wire:loading wire:target="save" />
                Enregistrer
            </x-button>
        </div>
    </div>
</div>
