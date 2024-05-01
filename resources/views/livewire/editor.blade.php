<div>
    @if ($label)
        <span class="mb-4 block font-sans text-xl font-semibold text-skin-inverted">
            {{ $label }}
        </span>
    @endif

    <div
        x-data="editorConfig($wire.entangle('body').defer)"
        @editor-control-clicked.window="handleClick($event.detail, $el)"
        class="overflow-hidden rounded-md shadow-md"
    >
        <div class="relative flex h-12 w-full items-center justify-between overflow-x-hidden bg-skin-card sm:h-10">
            <div class="flex h-12 items-center sm:h-10">
                <button
                    type="button"
                    @click="mode = 'write'"
                    class="flex h-full cursor-pointer items-center px-4 font-medium text-skin-base hover:bg-skin-card-muted"
                    :class="{ 'text-green-500 border-b border-green-500': mode === 'write' }"
                >
                    <x-heroicon-o-pencil class="mr-2 h-4 w-4" />
                    <span>Saisi</span>
                </button>

                <button
                    type="button"
                    @click="mode = 'preview'"
                    wire:click="preview"
                    class="flex h-full cursor-pointer items-center px-4 font-medium text-skin-base hover:bg-skin-card-muted"
                    :class="{ 'text-green-500 border-b border-green-500': mode === 'preview' }"
                >
                    Preview
                </button>
            </div>
            <x-forms.editor.controls />
        </div>

        <div x-show="mode === 'write'">
            <div class="relative flex flex-col">
                <textarea
                    class="hide-scroll h-full min-h-[250px] w-full resize-none border-none bg-skin-input p-5 leading-loose tracking-tighter text-skin-base focus:border focus:border-skin-input focus:outline-none"
                    id="body"
                    name="body"
                    aria-label="Body"
                    placeholder="{{ $placeholder }}"
                    wire:model.debounce.150="body"
                    required
                    @keydown.cmd.enter="submit($event)"
                    @keydown.ctrl.enter="submit($event)"
                ></textarea>
            </div>

            <div class="flex items-center justify-end gap-x-5 gap-y-4">
                @if ($hasCancelButton)
                    <x-default-button type="button" class="inline-flex">Annuler</x-default-button>
                @endif

                @if ($hasButton)
                    <x-button type="{{ $buttonType }}">
                        {{ $buttonLabel }}
                    </x-button>
                @endif
            </div>
        </div>

        <div x-show="mode === 'preview'" x-cloak>
            <div
                class="prose prose-green relative z-30 h-full max-w-none break-words bg-skin-card p-5"
                id="editor-preview"
            >
                {!! $this->preview !!}
            </div>
        </div>
    </div>
</div>
