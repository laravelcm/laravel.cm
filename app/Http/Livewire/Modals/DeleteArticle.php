<?php

namespace App\Http\Livewire\Modals;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class DeleteArticle extends ModalComponent
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

    public function delete()
    {
        $this->authorize(ArticlePolicy::DELETE, $this->article);

        $this->article->delete();

        session()->flash('status', 'La discussion a été supprimé avec tous ses commentaires.');

        $this->redirectRoute('articles');
    }

    public function render()
    {
        return view('livewire.modals.delete-article');
    }
}
