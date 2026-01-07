<?php

declare(strict_types=1);

namespace Mckenziearts\LivewireMarkdownEditor\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

final class MarkdownEditor extends Component
{
    use WithFileUploads;

    #[Modelable]
    public ?string $content = null;

    /** @var array<int, TemporaryUploadedFile> */
    public array $attachments = [];

    public string $placeholder = 'Leave a comment...';

    public int $rows = 10;

    public bool $showToolbar = true;

    public bool $showUpload = true;

    public ?string $class = null;

    #[Computed]
    public function parsedContent(): string
    {
        if (blank($this->content)) {
            return '';
        }

        $environment = new Environment([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new TaskListExtension);
        $environment->addExtension(new HighlightCodeExtension(theme: config('livewire-markdown-editor.theme'))); // @phpstan-ignore-line

        $converter = new MarkdownConverter(environment: $environment);

        return $converter->convert($this->content)->getContent();
    }

    public function updatedAttachments(): void
    {
        /** @var string $disk */
        $disk = config('livewire-markdown-editor.disk');

        foreach ($this->attachments as $attachment) {
            /** @var string $path */
            $path = $attachment->store('', $disk);
            $url = Storage::disk($disk)->url($path);
            $filename = $attachment->getClientOriginalName();

            if (str_starts_with($attachment->getMimeType(), 'image/')) {
                $this->content .= "\n![{$filename}]({$url})\n";
            } else {
                $this->content .= "\n[{$filename}]({$url})\n";
            }
        }

        $this->attachments = [];
    }

    public function render(): View
    {
        return view('livewire-markdown-editor::components.markdown-editor');
    }
}
