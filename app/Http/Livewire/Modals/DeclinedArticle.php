<?php

namespace App\Http\Livewire\Modals;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\SendDeclinedArticle;
use Illuminate\Support\Facades\Cache;
use LivewireUI\Modal\ModalComponent;
use App\Policies\ArticlePolicy;
use App\Models\Article;

class DeclinedArticle extends ModalComponent
{
    use AuthorizesRequests;

    public ?string $raison = null;

    public ?string $description = null;

    public ?Article $article = null;

    protected $rules = [
        'raison' => 'required|string|min:6',
        'description' => 'required|string',
    ];

    public function mount(int $id): void
    {
        $this->article = Article::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function declined(): void
    {
        $data = $this->validate();

        $this->authorize(ArticlePolicy::DISAPPROVE, $this->article);

        $this->article->update(['declined_at' => now()]); // @phpstan-ignore-line

        Cache::forget('post-'.$this->article->id); // @phpstan-ignore-line

        $this->article->user->notify(new SendDeclinedArticle($this->article, $data)); // @phpstan-ignore-line

        session()->flash('status', __('L\'article a été décliné et le mail a été envoyé à l\'auteur pour le notifier.'));

        $this->redirectRoute('articles');
    }


    public function render()
    {
        return view('livewire.modals.declined-article');
    }
}
