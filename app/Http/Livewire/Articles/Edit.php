<?php

declare(strict_types=1);

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Edit extends Component
{
    use WithArticleAttributes;
    use WithFileUploads;
    use WithTagsAssociation;

    public Article $article;

    public ?string $preview = null;

    public bool $alreadySubmitted = false;

    /**
     * @var string[]
     */
    protected $listeners = ['markdown-x:update' => 'onMarkdownUpdate'];

    public function mount(Article $article): void
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->body = $article->body;
        $this->slug = $article->slug;
        $this->show_toc = $article->show_toc;
        $this->submitted_at = $article->submitted_at;
        $this->published_at = $article->published_at ? $article->publishedAt()?->format('Y-m-d') : null;
        $this->canonical_url = $article->originalUrl();
        $this->preview = $article->getFirstMediaUrl('media');
        $this->associateTags = $this->tags_selected = old('tags', $article->tags()->pluck('id')->toArray());
    }

    public function submit(): void
    {
        $this->alreadySubmitted = null !== $this->article->submitted_at;
        $this->submitted_at = $this->article->submitted_at ?? now();
        $this->store();
    }

    public function store(): void
    {
        $this->save();
    }

    public function save(): void
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
            'published_at' => $this->published_at,
        ]);

        $this->article->syncTags($this->associateTags);

        if ($this->file) {
            $this->article->addMedia($this->file->getRealPath())->toMediaCollection('media');
        }

        Cache::forget('post-'.$this->article->id);

        $user->hasRole('user') ?
            $this->redirectRoute('dashboard') :
            $this->redirectRoute('articles.show', $this->article);
    }

    public function render(): View
    {
        return view('livewire.articles.edit', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->get(),
        ]);
    }
}
