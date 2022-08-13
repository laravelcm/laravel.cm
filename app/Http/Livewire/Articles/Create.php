<?php

namespace App\Http\Livewire\Articles;

use App\Events\ArticleWasSubmittedForApproval;
use App\Gamify\Points\PostCreated;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithTagsAssociation, WithArticleAttributes;

    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount()
    {
        /** @var User $user */
        $user = Auth::user();

        $this->published_at = now()->toDateTimeLocalString();
        $this->submitted_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
        $this->approved_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
    }

    public function submit()
    {
        $this->submitted_at = now();
        $this->store();
    }

    public function store()
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();

        /** @var Article $article */
        $article = Article::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'published_at' => $this->published_at,
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

        if ($article->isAwaitingApproval()) {
            // Envoi de la notification sur le channel Telegram pour la validation de l'article.
            event(new ArticleWasSubmittedForApproval($article));

            session()->flash('status', 'Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.');
        }

        if ($user->hasAnyRole(['admin', 'moderator'])) {
            givePoint(new PostCreated($article));
        }

        $user->hasRole('user') ?
            $this->redirectRoute('dashboard') :
            $this->redirectRoute('articles.show', $article);
    }

    public function render(): View
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
