<div>
    @if ($label)
        <span class="text-xl text-skin-inverted font-semibold mb-4 block font-sans">
            {{ $label }}
        </span>
    @endif

    <div
        x-data="editorConfig($wire.entangle('body').defer)"
        @editor-control-clicked.window="handleClick($event.detail, $el)"
        class="rounded-md shadow-md overflow-hidden"
    >
        <div class="relative flex items-center justify-between w-full h-12 overflow-x-hidden bg-skin-card sm:h-10">
            <div class="flex items-center h-12 sm:h-10">
                <button
                    type="button"
                    @click="mode = 'write'"
                    class="flex items-center h-full px-4 font-medium text-skin-base cursor-pointer hover:bg-skin-card-muted"
                    :class="{ 'text-green-500 border-b border-green-500': mode === 'write' }"
                >
                    <x-heroicon-o-pencil class="w-4 h-4 mr-2" />
                    <span>Saisi</span>
                </button>

                <button
                    type="button"
                    @click="mode = 'preview'"
                    wire:click="preview"
                    class="flex items-center h-full px-4 font-medium text-skin-base cursor-pointer hover:bg-skin-card-muted"
                    :class="{ 'text-green-500 border-b border-green-500': mode === 'preview' }"
                >
                    Preview
                </button>
            </div>
            <x-forms.editor.controls />
        </div>

        <div x-show="mode === 'write'">
            <div class="flex flex-col relative">
                <textarea
                    class="w-full h-full min-h-[250px] bg-skin-input leading-loose tracking-tighter text-skin-base hide-scroll resize-none border-none p-5 focus:border focus:border-skin-input focus:outline-none"
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

            <div class="flex items-center justify-end gap-y-4 gap-x-5">

                @if($hasCancelButton)
                    <x-default-button type="button" class="inline-flex">
                        Annuler
                    </x-default-button>
                @endif

                @if ($hasButton)
                    <x-button type="{{ $buttonType }}">
                        {{ $buttonLabel }}
                    </x-button>
                @endif
            </div>
        </div>

        <div x-show="mode === 'preview'" x-cloak>
            <div class="h-full bg-skin-card relative z-30 p-5 prose prose-green max-w-none break-words" id="editor-preview">
                {!! $this->preview !!}
            </div>
        </div>
    </div>
</div>
