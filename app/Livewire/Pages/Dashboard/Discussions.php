<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Dashboard;

use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Discussion;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Discussions extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?int $discussionToDelete = null;

    #[Computed(persist: true)]
    public function user(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    #[Computed]
    public function discussions(): LengthAwarePaginator
    {
        return Discussion::with('tags')
            ->withCount('replies')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function confirmDelete(int $discussionId): void
    {
        $this->discussionToDelete = $discussionId;

        Flux::modal('confirm-delete-discussion')->show();
    }

    public function delete(): void
    {
        if (! $this->discussionToDelete) {
            return;
        }

        /** @var Discussion $discussion */
        $discussion = Discussion::query()->findOrFail($this->discussionToDelete);

        $this->authorize('delete', $discussion);

        resolve(DeleteDiscussionAction::class)->execute($discussion);

        Flux::toast(
            text: __('notifications.discussion.deleted'),
            variant: 'success',
        );

        $this->discussionToDelete = null;

        Flux::modal('confirm-delete-discussion')->close();
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard.discussions');
    }
}
