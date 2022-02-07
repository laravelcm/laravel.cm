<?php

namespace App\Http\Livewire\Modals;

use App\Gamify\Points\PostCreated;
use App\Models\Article;
use App\Notifications\SendApprovedArticle;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use LivewireUI\Modal\ModalComponent;

class ApprovedArticle extends ModalComponent
{
    use AuthorizesRequests;

    public ?Article $article = null;

    public function mount(int $id)
    {
        $this->article = Article::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function approved()
    {
        $this->authorize(ArticlePolicy::UPDATE, $this->article);

        $this->article->update(['approved_at' => now()]);

        givePoint(new PostCreated($this->article));

        Cache::forget('post-' . $this->article->id);

        $this->article->author->notify(new SendApprovedArticle($this->article));

        session()->flash('status', 'L\'article a été approuvé et le mail a été envoyé à l\'auteur pour le notifier.');

        $this->redirectRoute('articles');
    }

    public function render()
    {
        return view('livewire.modals.approved-article');
    }
}
