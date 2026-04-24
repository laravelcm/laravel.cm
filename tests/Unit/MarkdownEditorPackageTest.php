<?php

declare(strict_types=1);

use Mckenziearts\LivewireMarkdownEditor\Livewire\MarkdownEditor;

uses(Tests\TestCase::class);

describe('livewire-markdown-editor package contract', function (): void {
    test('component exposes a rules() method (v1.3 security patch)', function (): void {
        $reflection = new ReflectionClass(MarkdownEditor::class);

        expect($reflection->hasMethod('rules'))->toBeTrue()
            ->and($reflection->getMethod('rules')->isPublic())->toBeTrue();
    });

    test('component exposes updatedAttachments() hook', function (): void {
        $reflection = new ReflectionClass(MarkdownEditor::class);

        expect($reflection->hasMethod('updatedAttachments'))->toBeTrue()
            ->and($reflection->getMethod('updatedAttachments')->isPublic())->toBeTrue();
    });

    test('config exposes hardened upload defaults', function (): void {
        $config = config('livewire-markdown-editor.upload');

        expect($config)->toBeArray()
            ->and($config['images_only'] ?? null)->toBeTrue()
            ->and($config['allowed_extensions'] ?? [])->toBeArray()
            ->and(array_diff($config['allowed_extensions'] ?? [], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif']))->toBeEmpty()
            ->and($config['max_size'] ?? PHP_INT_MAX)->toBeLessThanOrEqual(4096);
    });
})->group('architecture');
