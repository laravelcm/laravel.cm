<?php

namespace App\Http\Livewire\Articles;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public ?string $title = null;
    public ?string $slug = null;
    public ?string $body = null;
    public ?string $canonical_url = null;
    public bool $show_toc = true;
    public array $tags_selected = [];
    public $file;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function removeImage()
    {
        $this->file = null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'body' => ['required'],
            'tags_selected' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'canonical_url' => 'url|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'article est requis',
            'title.max' => 'Le titre ne peux pas dépasser 100 caractères',
            'body.required' => 'Le titre de l\'article est requis',
        ];
    }

    public function updatedTitle(string $value)
    {
        $this->slug = Str::slug($value);
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function submit()
    {
        dd($this->tags_selected);
    }

    public function draft()
    {
    }

    public function store()
    {
    }

    public function render()
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
