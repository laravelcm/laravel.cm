<div>
    <div
        x-data="{ preview: false }"
        class="ring-1 ring-gray-300 rounded-lg overflow-hidden dark:ring-white/20 bg-white dark:bg-gray-900"
    >
        <div class="flex gap-4 border-b border-gray-300 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
            <!-- Tabs view Mode -->
            <div class="flex">
                <button
                    type="button"
                    @click="preview = false"
                    :class="!preview ? 'text-gray-900 ring-1 rounded-t-lg ring-gray-200 dark:ring-white/10 dark:text-white bg-white dark:bg-gray-900' : 'text-gray-600 dark:text-gray-400'"
                    class="px-4 py-2.5 text-sm font-medium transition-colors hover:text-gray-900 dark:hover:text-white"
                >
                    {{ __('Write') }}
                </button>
                <button
                    type="button"
                    @click="preview = true"
                    :class="preview ? 'text-gray-900 ring-1 rounded-t-lg ring-gray-200 dark:ring-white/10 dark:text-white bg-white dark:bg-gray-900' : 'text-gray-600 dark:text-gray-400'"
                    class="px-4 py-2.5 text-sm font-medium transition-colors hover:text-gray-900 dark:hover:text-white"
                >
                    {{ __('Preview') }}
                </button>
            </div>

            <!-- Toolbar: only visible in write mode -->
            @if ($showToolbar)
                <div x-show="!preview" class="flex-1 flex justify-end">
                    <markdown-toolbar
                        for="markdown-textarea-{{ $this->getId() }}"
                        class="flex items-center gap-1 px-2"
                    >
                        <md-header>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300" title="Heading (Ctrl+Shift+H)">
                                <x-phosphor-text-h class="size-5" aria-hidden="true" />
                            </button>
                        </md-header>

                        <md-bold>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300" title="Bold (Ctrl+B)">
                                <x-phosphor-text-b class="size-5" aria-hidden="true" />
                            </button>
                        </md-bold>

                        <md-italic>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300" title="Italic (Ctrl+I)">
                                <x-phosphor-text-italic class="size-5" aria-hidden="true" />
                            </button>
                        </md-italic>

                        <md-quote>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300" title="Quote (Ctrl+Shift+.)">
                                <x-phosphor-quotes class="size-5" aria-hidden="true" />
                            </button>
                        </md-quote>

                        <md-code>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300" title="Code (Ctrl+E)">
                                <x-phosphor-code-simple class="size-5" aria-hidden="true" />
                            </button>
                        </md-code>

                        <md-link>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300" title="Link (Ctrl+K)">
                                <x-phosphor-link class="size-5" aria-hidden="true" />
                            </button>
                        </md-link>

                        <div class="w-px h-6 bg-gray-300 dark:bg-gray-700 mx-1.5"></div>

                        <md-unordered-list>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300" title="Unordered list (Ctrl+Shift+8)">
                                <x-phosphor-list-bullets class="size-5" aria-hidden="true" />
                            </button>
                        </md-unordered-list>

                        <md-ordered-list>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300" title="Ordered list (Ctrl+Shift+7)">
                                <x-phosphor-list-numbers class="size-5" aria-hidden="true" />
                            </button>
                        </md-ordered-list>

                        <md-task-list>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300" title="{{ __('Task list') }}">
                                <x-phosphor-list-checks class="size-5" aria-hidden="true" />
                            </button>
                        </md-task-list>

                        <div class="w-px h-6 bg-gray-300 dark:bg-gray-700 mx-1.5"></div>

                        <md-mention>
                            <button type="button" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300" title="{{ __('Mention') }}">
                                <x-phosphor-at class="size-5" aria-hidden="true" />
                            </button>
                        </md-mention>

                        @if ($showUpload)
                            <label class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-700 dark:text-gray-300" title="{{ __('Attach files') }}">
                                <input type="file" wire:model="attachments" multiple accept="image/*,.pdf,.doc,.docx" class="hidden">
                                <x-phosphor-images class="size-5" aria-hidden="true" />
                            </label>
                        @endif
                    </markdown-toolbar>
                </div>
            @endif
        </div>

        <!-- Textarea (mode Write) -->
        <div x-show="!preview">
            <textarea
                id="markdown-textarea-{{ $this->getId() }}"
                wire:model.live.debounce.500ms="content"
                rows="{{ $rows }}"
                placeholder="{{ $placeholder }}"
                @class([
                    'w-full h-auto p-3 border-0 max-h-138 resize-y focus:outline-none focus:ring-0 text-gray-700 bg-white dark:bg-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500',
                    $class
                ])
            ></textarea>
        </div>

        <!-- Preview -->
        <div
            x-show="preview"
            class="p-3 min-h-50"
            wire:loading.class="opacity-50"
        >
            @if (blank($content))
                <div class="text-gray-500 dark:text-gray-400 italic">
                    {{ __('Nothing to preview') }}
                </div>
            @else
                <div class="prose max-w-none dark:prose-invert prose-headings:font-heading prose-emerald">
                    {!! $this->parsedContent !!}
                </div>
            @endif
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between">
        <a href="https://docs.github.com/en/get-started/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax" target="_blank" class="inline-flex items-center px-2 py-0.5 gap-1.5 bg-gray-100 hover:bg-gray-200/70 rounded text-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-white/20">
            <x-phosphor-markdown-logo-duotone class="size-5" aria-hidden="true" />
            <span class="text-xs font-medium">
                {{ __('Styling with Markdown is supported') }}
            </span>
        </a>

        @if ($showUpload)
            <div wire:loading wire:target="attachments" class="inline-flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                <svg
                    class="animate-spin size-4 text-primary-600"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    />
                </svg>
                {{ __('Uploading...') }}
            </div>
        @endif
    </div>
</div>
