<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithTagsAssociation, WithArticleAttributes;

    public Article $article;
    public ?string $preview = null;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->body = $article->body;
        $this->slug = $article->slug;
        $this->show_toc = $article->show_toc;
        $this->canonical_url = $article->originalUrl();
        $this->preview = $article->cover_image_url;
        $this->associateTags = $this->tags_selected = old('tags', $article->tags()->pluck('id')->toArray());
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function store()
    {
        $this->save();
    }

    public function save()
    {
        $this->validate();

        $this->article->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
            'user_id' => auth()->id(),
            'cover_image' => $this->article->cover_image ?? $this->file?->store('/', 'public'),
        ]);

        $this->article->syncTags($this->associateTags);

        $this->redirectRoute('articles.show', $this->article);
    }

    public function render()
    {
        return view('livewire.articles.edit', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
