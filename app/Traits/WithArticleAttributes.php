<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait WithArticleAttributes
{
    public ?string $title = null;
    public ?string $slug = null;
    public string $body = '';
    public ?string $canonical_url = null;
    public bool $show_toc = false;
    public ?string $submitted_at = null;
    public ?string $approved_at = null;
    public $file;

    protected $rules = [
        'title' => 'required|max:150',
        'body' => 'required',
        'tags_selected' => 'nullable|array',
        'canonical_url' => 'nullable|url',
        'file' => 'nullable|image|max:2048', // 1MB Max
    ];

    public function removeImage()
    {
        $this->file = null;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'article est requis',
            'title.max' => 'Le titre ne peux pas dépasser 150 caractères',
            'body.required' => 'Le contenu de l\'article est requis',
            'file.required' => 'L\'image de couverture est requise (dans les paramètres avancées)',
        ];
    }

    public function updatedTitle(string $value)
    {
        $this->slug = Str::slug($value);
    }
}
