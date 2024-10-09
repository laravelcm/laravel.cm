<div class="mt-8 border-t border-skin-base pt-5">
    <h3 class="mb-6 font-sans text-lg font-medium text-gray-900 sm:text-xl">Laissez votre réponse</h3>

    <livewire:markdown-x
        :content="$body"
        :autofocus="false"
        key="create-reply"
        :style="[
        'textarea' => 'w-full h-full border border-skin-input focus:border-skin-base focus:outline-none p-4 rounded-b-lg',
        'height' => 'h-[250px]',
    ]"
    />

    @error('body')
        <p class="mt-2 text-sm font-normal leading-5 text-red-500">{{ $message }}</p>
    @enderror

    <div class="mt-4 flex items-start justify-between gap-x-8 lg:items-center">
        <p class="font-normal text-gray-500 dark:text-gray-400">
            Assurez-vous d'avoir lu nos
            <a href="{{ route('rules') }}" class="font-medium text-primary-600 hover:text-primary-600-hover">
                règles de conduite
            </a>
            avant de répondre à ce thread.
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
