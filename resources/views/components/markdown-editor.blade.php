@props([
    'model' => null,
    'height' => null,
    'preview' => false,
    'previewStyle' => 'tab',
    'hideModeSwitch' => true,
    'toolbarItems' => null,
    'placeholder' => '',
    'label' => null,
    'description' => null,
    'error' => null,
    'badge' => null,
    'language' => app()->getLocale(),
])

@php
    $model = $attributes->wire('model')->value();

    $defaultToolbarItems = [
        ['heading', 'bold', 'italic', 'strike'],
        ['hr', 'quote'],
        ['ul', 'ol', 'task', 'indent', 'outdent'],
        ['table', 'link', 'image'],
        ['code', 'codeblock'],
    ];

    $toolbar = $toolbarItems ?? $defaultToolbarItems;

    $config = [
        'model' => $model,
        'height' => $height,
        'preview' => $preview,
        'previewStyle' => $previewStyle,
        'hideModeSwitch' => $hideModeSwitch,
        'toolbarItems' => $toolbar,
        'placeholder' => $placeholder,
        'language' => $language,
    ];
@endphp

<div class="space-y-2">
    @if ($label)
        <div class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ $label }}
            </label>

            @if ($badge)
                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20">
                    {{ $badge }}
                </span>
            @endif
        </div>
    @endif

    @if ($description)
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif

    <div
        x-data="markdownEditor(@js($config))"
        x-init="init()"
        x-on:destroy.window="destroy()"
        wire:ignore
        @class(['markdown-editor-no-preview' => !$preview])
    >
        <div x-ref="editor"></div>
    </div>

    @if ($error)
        <p class="text-sm text-red-600 dark:text-red-400">
            {{ $error }}
        </p>
    @endif
</div>
