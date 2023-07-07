<?php

declare(strict_types=1);

namespace App\Http\Livewire\Articles;

use App\Events\ArticleWasSubmittedForApproval;
use App\Gamify\Points\PostCreated;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Create extends Component
{
    use WithArticleAttributes;
    use WithFileUploads;
    use WithTagsAssociation;

    /**
     * @var string[]
     */
    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->published_at = now();
        $this->submitted_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
        $this->approved_at = $user->hasAnyRole(['admin', 'moderator']) ? now() : null;
    }

    public function submit(): void
    {
        $this->submitted_at = now();
        $this->store();
    }

    public function store(): void
    {
        $this->validate();

        /** @var User $user */
        $user = Auth::user();

        if ($this->published_at && ! ($this->published_at instanceof DateTimeInterface)) {
            $this->published_at = new Carbon(
                time: $this->published_at,
                tz: config('app.timezone')
            );
        }

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
            $article->syncTags(tags: $this->associateTags);
        }

        if ($this->file) {
            $article->addMedia($this->file->getRealPath())->toMediaCollection('media');
        }

        if ($article->isAwaitingApproval()) {
            if (app()->environment('production')) {
                // Envoi de la notification sur le channel Telegram pour la validation de l'article.
                event(new ArticleWasSubmittedForApproval($article));
            }

            session()->flash('status', __('Merci d\'avoir soumis votre article. Vous aurez des nouvelles que lorsque nous accepterons votre article.'));
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
