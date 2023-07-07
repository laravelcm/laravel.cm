<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Markdown\MarkdownHelper;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Editor extends Component
{
    public string $placeholder = 'laisser une réponse...';

    public ?string $label = null;

    public ?string $body = null;

    public bool $hasButton = false;

    public bool $hasCancelButton = false;

    public string $buttonType = 'submit';

    public string $buttonLabel = 'Enregistrer';

    public function getPreviewProperty(): string
    {
        return MarkdownHelper::parseLiquidTags(replace_links((string) md_to_html($this->body ?: '')));
    }

    public function preview(): void
    {
        $this->emit('previewRequested');
    }

    public function updatedBody(): void
    {
        $this->emitUp('editor:update', $this->body);
    }

    public function render(): View
    {
        return view('livewire.editor');
    }
}
