<?php

namespace App\Http\Livewire;

use App\Markdown\MarkdownHelper;
use Livewire\Component;

class Editor extends Component
{
    public string $placeholder = 'laisser une réponse...';
    public ?string $label = null;
    public ?string $body = null;
    public bool $hasButton = false;
    public bool $hasCancelButton = false;
    public string $buttonType = 'submit';
    public string $buttonLabel = 'Enregistrer';

    public function getPreviewProperty()
    {
        return MarkdownHelper::parseLiquidTags(replace_links(md_to_html($this->body ?: '')));
    }

    public function preview()
    {
        $this->emit('previewRequested');
    }

    public function updatedBody()
    {
        $this->emitUp('editor:update', $this->body);
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
