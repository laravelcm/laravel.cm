<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Articles extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithoutUrlPagination;
    use WithPagination;

    #[Computed]
    public function articles(): LengthAwarePaginator
    {
        return Article::with('tags')
            ->withCount('reactions')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->badge()
            ->action(
                fn (array $arguments) => $this->dispatch(
                    'openPanel',
                    component: 'components.slideovers.article-form',
                    arguments: ['articleId' => $arguments['id']]
                )
            );
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('actions.delete'))
            ->color('danger')
            ->badge()
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                /** @var Article $article */
                $article = Article::query()->find($arguments['id']);

                $this->authorize('delete', $article);

                $article->delete();

                Notification::make()
                    ->success()
                    ->title(__('notifications.article.deleted'))
                    ->send();
            });
    }

    public function render(): View
    {
        return view('livewire.components.user.articles');
    }
}
