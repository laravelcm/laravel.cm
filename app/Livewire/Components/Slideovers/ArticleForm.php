<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Article\CreateArticleAction;
use App\Actions\Article\UpdateArticleAction;
use App\Data\ArticleData;
use App\Events\ArticleWasSubmittedForApproval;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Forms\ArticleFormObject;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class ArticleForm extends SlideOverComponent
{
    use WithAuthenticatedUser;
    use WithFileUploads;

    public ArticleFormObject $form;

    public ?Article $article = null;

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public static function closePanelOnClickAway(): bool
    {
        return false;
    }

    public function mount(?int $articleId = null): void
    {
        /** @var Article $article */
        $article = filled($articleId)
            ? Article::with('tags')->findOrFail($articleId)
            : new Article;

        $this->article = $article;

        $this->form->setArticle($this->article);
    }

    #[Computed]
    public function availableTags(): Collection
    {
        return Tag::query()
            ->whereJsonContains('concerns', 'post')
            ->orderBy('name')
            ->get();
    }

    public function updatedFormTitle(string $value): void
    {
        $this->form->slug = Str::slug($value);
    }

    public function save(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            throw new UnverifiedUserException(
                message: __('notifications.exceptions.unverified_user')
            );
        }

        if ($this->article?->id) {
            $this->authorize('update', $this->article);
        }

        $this->form->validate();

        $publishedFields = [
            'published_at' => $this->form->published_at
                ? Date::parse($this->form->published_at)
                : null,
            'submitted_at' => $this->form->is_draft ? null : now(),
        ];

        $articleData = array_merge([
            'title' => $this->form->title,
            'slug' => $this->form->slug,
            'canonical_url' => $this->form->canonical_url,
            'locale' => $this->form->locale,
            'body' => $this->form->body,
        ], $publishedFields);

        if ($this->article?->id) {
            $article = resolve(UpdateArticleAction::class)->execute(
                data: ArticleData::from($articleData),
                article: $this->article,
                user: $user
            );

            $this->handleMediaUpload($article);
            $article->tags()->sync($this->form->tags);

            Flux::toast(
                text: $article->submitted_at
                    ? __('notifications.article.submitted')
                    : __('notifications.article.updated'),
                variant: 'success'
            );
        } else {
            $article = resolve(CreateArticleAction::class)->execute(
                data: ArticleData::from($articleData),
                user: $user
            );

            $this->handleMediaUpload($article);
            $article->tags()->sync($this->form->tags);

            Flux::toast(
                text: $this->form->is_draft === false
                    ? __('notifications.article.submitted')
                    : __('notifications.article.created'),
                variant: 'success'
            );
        }

        if ($this->form->is_draft === false) {
            event(new ArticleWasSubmittedForApproval($article));
        }

        $this->redirect(route('articles.show', ['article' => $article]), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.article-form');
    }

    private function handleMediaUpload(Article $article): void
    {
        if ($this->form->media instanceof TemporaryUploadedFile) {
            $article->clearMediaCollection('media');

            $article->addMedia($this->form->media->getRealPath())
                ->usingFileName($this->form->media->getClientOriginalName())
                ->toMediaCollection('media');
        }
    }
}
