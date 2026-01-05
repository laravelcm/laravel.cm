<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Article;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

final class ArticleFormObject extends Form
{
    public ?int $id = null;

    public string $title = '';

    public string $slug = '';

    public ?string $canonical_url = null;

    public bool $is_draft = true;

    public ?string $published_at = null;

    public ?TemporaryUploadedFile $media = null;

    public ?string $currentMediaUrl = null;

    /** @var array<int> */
    public array $tags = [];

    public string $locale = 'fr';

    public string $body = '';

    public function setArticle(Article $article): void
    {
        $this->id = $article->id;
        $this->title = $article->title ?? '';
        $this->slug = $article->slug ?? '';
        $this->canonical_url = $article->canonical_url;
        $this->is_draft = ! $article->published_at;
        $this->published_at = $article->published_at?->format('Y-m-d');
        /** @var array<int> $tags */
        $tags = $article->tags->pluck('id')->toArray();
        $this->tags = $tags;

        $this->locale = $article->locale ?? app()->getLocale();
        $this->body = $article->body ?? '';

        if ($article->hasMedia('media')) {
            $this->currentMediaUrl = $article->getFirstMediaUrl('media');
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:10'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($this->id),
            ],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'is_draft' => ['required', 'boolean'],
            'published_at' => [
                Rule::requiredIf(fn (): bool => ! $this->is_draft),
                'nullable',
                'date',
            ],
            'media' => ['nullable', 'image', 'max:1024'],
            'tags' => ['required', 'array', 'min:1', 'max:3'],
            'tags.*' => ['required', 'integer', 'exists:tags,id'],
            'locale' => ['required', 'string', Rule::in(['en', 'fr'])],
            'body' => ['required', 'string', 'min:10'],
        ];
    }
}
