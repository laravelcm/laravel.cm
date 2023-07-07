<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

final class DeleteArticle extends ModalComponent
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

    public function delete(): void
    {
        $this->authorize(ArticlePolicy::DELETE, $this->article);

        $this->article->delete(); // @phpstan-ignore-line

        session()->flash('status', __('La discussion a été supprimé avec tous ses commentaires.'));

        $this->redirectRoute('articles');
    }

    public function render(): View
    {
        return view('livewire.modals.delete-article');
    }
}
