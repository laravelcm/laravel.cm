<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait WithArticleAttributes
{
    public ?string $title = null;

    public ?string $slug = null;

    public string $body = '';

    public ?string $canonical_url = null;

    public bool $show_toc = false;

    public ?Carbon $submitted_at = null;

    public ?Carbon $approved_at = null;

    public Carbon|string|null $published_at = null;

    public int $reading_time = 1;

    //@phpstan-ignore-next-line
    public $file;

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'title' => 'required|max:150',
        'body' => 'required',
        'tags_selected' => 'nullable|array',
        'canonical_url' => 'nullable|url',
        'file' => 'nullable|image|max:2048', // 1MB Max
    ];

    public function removeImage(): void
    {
        $this->file = null;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => __('Le titre de l\'article est requis'),
            'title.max' => __('Le titre ne peux pas dépasser 150 caractères'),
            'body.required' => __('Le contenu de l\'article est requis'),
            'file.required' => __('L\'image de couverture est requise (dans les paramètres avancées)'),
        ];
    }

    public function updatedTitle(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function onMarkdownUpdate(string $content): void
    {
        $this->body = $content;
        $this->reading_time = Str::readDuration($content);
    }
}
