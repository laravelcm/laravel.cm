<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
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
    public bool $submitted = true;
    public array $tags_selected = [];
    public ?string $submitted_at = null;
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
            'file' => 'required|image|max:1024', // 1MB Max
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
        $this->submitted_at = now();
        $this->store();
    }

    public function draft()
    {
        $this->submitted = false;
        $this->store();
    }

    public function store()
    {
        $article = Article::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'submitted' => $this->submitted,
            'submitted_at' => $this->submitted_at,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
        ]);

        if (count($this->tags_selected) > 0) {
            $article->tags()->detach();
            $article->tags()->attach($this->tags_selected);
        }

        if ($this->submitted) {
        }

        $this->redirect('/articles/me');
    }

    public function render()
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
