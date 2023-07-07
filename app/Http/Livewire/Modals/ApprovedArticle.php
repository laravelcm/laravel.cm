<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Gamify\Points\PostCreated;
use App\Models\Article;
use App\Notifications\SendApprovedArticle;
use App\Policies\ArticlePolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use LivewireUI\Modal\ModalComponent;

final class ApprovedArticle extends ModalComponent
{
    use AuthorizesRequests;

    public ?Article $article = null;

    public function mount(int $id): void
    {
        $this->article = Article::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function approved(): void
    {
        $this->authorize(ArticlePolicy::UPDATE, $this->article);

        $this->article->update(['approved_at' => now()]); // @phpstan-ignore-line

        givePoint(new PostCreated($this->article)); // @phpstan-ignore-line

        Cache::forget('post-'.$this->article->id); // @phpstan-ignore-line

        $this->article->user->notify(new SendApprovedArticle($this->article)); // @phpstan-ignore-line

        session()->flash('status', __('L\'article a été approuvé et le mail a été envoyé à l\'auteur pour le notifier.'));

        $this->redirectRoute('articles');
    }

    public function render(): View
    {
        return view('livewire.modals.approved-article');
    }
}
