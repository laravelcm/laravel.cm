<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Dashboard;

use App\Models\Article;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?int $articleToDelete = null;

    #[Computed(persist: true)]
    public function user(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    #[Computed]
    public function articles(): LengthAwarePaginator
    {
        return Article::with('tags')
            ->withCount('reactions')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function confirmDelete(int $articleId): void
    {
        $this->articleToDelete = $articleId;

        Flux::modal('confirm-delete-article')->show();
    }

    public function delete(): void
    {
        if (! $this->articleToDelete) {
            return;
        }

        /** @var Article $article */
        $article = Article::query()->findOrFail($this->articleToDelete);

        $this->authorize('delete', $article);

        $article->delete();

        Flux::toast(
            text: __('notifications.article.deleted'),
            variant: 'success',
        );

        $this->articleToDelete = null;

        Flux::modal('confirm-delete-article')->close();
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard.index');
    }
}
