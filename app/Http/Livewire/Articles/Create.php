<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithTagsAssociation, WithArticleAttributes;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount()
    {
        $user = Auth::user();

        $this->submitted = ! $user->hasAnyRole(['admin', 'moderator']);
        $this->submitted_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
        $this->approved_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
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

        $user = Auth::user();

        $article = Article::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'submitted' => $this->submitted,
            'submitted_at' => $this->submitted_at,
            'approved_at' => $this->approved_at,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
            'user_id' => $user->id,
        ]);

        if (collect($this->associateTags)->isNotEmpty()) {
            $article->syncTags($this->associateTags);
        }

        if ($this->file) {
            $article->addMedia($this->file->getRealPath())->toMediaCollection('media');
        }

        if ($this->submitted) {
            // Envoi du mail a l'admin pour la validation de l'article
            session()->flash('success', 'Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.');
        }

        $user->hasRole('user') ?
            $this->redirect('/articles/me') :
            $this->redirect('/admin/articles');
    }

    public function render()
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
