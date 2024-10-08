<?php

declare(strict_types=1);

namespace App\Livewire\Articles;

use App\Actions\Article\CreateArticleAction;
use App\Data\Article\CreateArticleData;
use App\Models\Tag;
use App\Models\User;
use App\Traits\WithArticleAttributes;
use App\Traits\WithTagsAssociation;

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

        $article = app(CreateArticleAction::class)->execute(CreateArticleData::from([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'published_at' => $this->published_at,
            'submitted_at' => $this->submitted_at,
            'approved_at' => $this->approved_at,
            'show_toc' => $this->show_toc,
            'canonical_url' => $this->canonical_url,
            'user_id' => $user->id,
        ]));


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
