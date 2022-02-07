<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\SendSubmittedArticle;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithTagsAssociation, WithArticleAttributes;

    public Article $article;
    public ?string $preview = null;
    public bool $alreadySubmitted = false;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->body = $article->body;
        $this->slug = $article->slug;
        $this->show_toc = $article->show_toc;
        $this->submitted_at =  $article->submitted_at;
        $this->canonical_url = $article->originalUrl();
        $this->preview = $article->getFirstMediaUrl('media');
        $this->associateTags = $this->tags_selected = old('tags', $article->tags()->pluck('id')->toArray());
    }

    public function onMarkdownUpdate(string $content)
    {
        $this->body = $content;
    }

    public function submit()
    {
        $this->alreadySubmitted = $this->article->submitted_at !== null;
        $this->submitted_at =  $this->article->submitted_at ?? now();
        $this->store();
    }

    public function store()
    {
        $this->save();
    }

    public function save()
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();

        $this->article->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
            'submitted_at' => $this->submitted_at,
        ]);

        $this->article->syncTags($this->associateTags);

        if ($this->file) {
            $this->article->addMedia($this->file->getRealPath())->toMediaCollection('media');
        }

        if (! $this->alreadySubmitted) {
            // Envoi du mail a l'admin pour la validation de l'article
            $admin = User::findByEmailAddress('monneylobe@gmail.com');
            Notification::send($admin, new SendSubmittedArticle($this->article));

            session()->flash('status', 'Merci d\'avoir soumis votre article. Vous aurez des nouvelles uniquement quand nous accepterons votre article.');
        }

        Cache::forget('post-' . $this->article->id);

        $user->hasRole('user') ?
            $this->redirectRoute('dashboard') :
            $this->redirectRoute('articles.show', $this->article);
    }

    public function render()
    {
        return view('livewire.articles.edit', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
