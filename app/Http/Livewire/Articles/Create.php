<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithTagsAssociation;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithTagsAssociation;

    public ?string $title = null;
    public ?string $slug = null;
    public ?string $body = null;
    public ?string $canonical_url = null;
    public bool $show_toc = true;
    public bool $submitted = true;
    public ?string $submitted_at = null;
    public $file;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    protected $rules = [
        'title' => ['required', 'max:100'],
        'body' => ['required'],
        'tags_selected' => 'nullable|array',
        'canonical_url' => 'nullable|url',
        'file' => 'required|image|max:1024', // 1MB Max
    ];

    public function mount()
    {
        $this->submitted = ! auth()->user()->hasAnyRole(['admin', 'moderator']);
        $this->submitted_at = auth()->user()->hasAnyRole(['admin', 'moderator']) ? now() : null;
    }

    public function removeImage()
    {
        $this->file = null;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'article est requis',
            'title.max' => 'Le titre ne peux pas dépasser 100 caractères',
            'body.required' => 'Le contenu de l\'article est requis',
            'file.required' => 'L\'image de couverture est requise (dans les paramètres avancées)',
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
        $this->validate();

        $article = Article::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'submitted' => $this->submitted,
            'submitted_at' => $this->submitted_at,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
            'user_id' => auth()->id(),
            'cover_image' => $this->file->store('/', 'public'),
        ]);

        $article->syncTags($this->associateTags);

        if ($this->submitted) {
            // Envoi du mail a l'admin pour la validation de l'article
            session()->flash('success', 'Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.');
            $this->redirect('/articles/me');
        }

        $this->redirect('/admin/articles');
    }

    public function render()
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
