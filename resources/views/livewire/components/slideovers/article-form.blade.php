<x-form-slider-over
    :title="$article->id ? $article->title : __('global.launch_modal.article_action')"
    action="save"
>
    <div class="space-y-6">
        <div x-data="{ expanded: false }">
            <button
                @click="expanded = ! expanded"
                type="button"
                class="relative inline-flex items-center gap-2 px-4 py-3 rounded-lg text-sm font-medium leading-4 text-gray-500 ring-1 ring-offset-2 ring-yellow-400 dark:text-gray-400 bg-gray-50 hover:bg-gray-100/70 dark:bg-gray-800 dark:hover:bg-white/20 dark:ring-offset-gray-800"
            >
                <x-untitledui-alert-triangle class="size-4 text-yellow-500 dark:text-yellow-400" aria-hidden="true" />
                {{ __('pages/article.advice.title') }}
                <x-untitledui-chevron-down class="size-4" aria-hidden="true" />

                <span class="absolute top-0 right-0 flex size-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full size-3 bg-yellow-400"></span>
                </span>
            </button>

            <div class="mt-4 prose prose-sm prose-primary leading-5 max-w-none dark:prose-invert" x-show="expanded" x-collapse>
                <p>{{ __('pages/article.advice.content') }}</p>
                <p>{{ __('pages/article.advice.twitter') }}</p>
                <p>{!! __('pages/article.advice.submission') !!}</p>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <flux:input
                wire:model.live.debounce="form.title"
                :label="__('validation.attributes.title')"
                :placeholder="__('validation.attributes.title')"
                :badge="__('validation.hints.required')"
                required
            />

            <flux:input
                wire:model="form.canonical_url"
                type="url"
                :label="__('pages/article.form.canonical_url')"
                :placeholder="__('pages/article.form.canonical_url')"
                :description="__('pages/article.canonical_help')"
            />

            <div class="grid grid-cols-2 gap-4">
                <flux:checkbox
                    wire:model.live="form.is_draft"
                    :label="__('pages/article.form.draft')"
                    :description="__('pages/article.draft_help')"
                />

                @if (!$form->is_draft)
                    <flux:date-picker
                        wire:model="form.published_at"
                        :label="__('pages/article.form.published_at')"
                        :locale="app()->getLocale() === 'fr' ? 'fr-FR' : 'en-EN'"
                    />
                @endif
            </div>

            <div class="space-y-2">
                <flux:file-upload
                    wire:model="form.media"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/avif"
                    :label="__('pages/article.form.cover')"
                >
                    <flux:file-upload.dropzone
                        :heading="__('validation.attributes.dropzone')"
                        :text="__('validation.hints.dropzone')"
                        icon="photo"
                        inline
                    />
                </flux:file-upload>

                <div>
                    @if ($form->media)
                        <flux:file-item
                            :image="$form->media->temporaryUrl()"
                            :heading="$form->media->getClientOriginalName()"
                            :size="$form->media->getSize()"
                        >
                            <x-slot name="actions">
                                <flux:file-item.remove />
                                {{--<flux:file-item.remove wire:click="$set('form.media', null)" />--}}
                            </x-slot>
                        </flux:file-item>
                    @elseif ($form->currentMediaUrl)
                        <flux:file-item
                            :image="$form->currentMediaUrl"
                            :heading="__('Image actuelle')"
                        />
                    @endif
                </div>

                <flux:error name="form.media" />
            </div>

            <flux:pillbox
                wire:model="form.tags"
                :placeholder="__('Select tags (1-3)')"
                :label="__('Tags')"
                :badge="__('validation.hints.required')"
                multiple
            >
                @foreach ($this->availableTags as $tag)
                    <flux:pillbox.option value="{{ $tag->id }}">{{ $tag->name }}</flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <div class="space-y-2">
                <flux:radio.group
                    wire:model="form.locale"
                    :label="__('validation.attributes.locale')"
                    variant="segmented"
                    size="sm"
                    class="w-48"
                >
                    <flux:radio value="fr" label="Français" />
                    <flux:radio value="en" label="English" />
                </flux:radio.group>
                <flux:description>{{ __('global.locale_help') }}</flux:description>
            </div>

            <div class="space-y-2">
                <flux:field>
                    <flux:label :badge="__('validation.hints.required')">
                        {{ __('validation.attributes.content') }}
                    </flux:label>

                    <livewire:markdown-editor
                        wire:model="form.body"
                        :placeholder="__('Commencez votre article...')"
                        :rows="10"
                        :show-upload="false"
                    />

                    <flux:error name="form.body" />
                </flux:field>

                <x-torchlight />
            </div>
        </div>
    </div>
</x-form-slider-over>
