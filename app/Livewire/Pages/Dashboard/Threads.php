<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Dashboard;

use App\Actions\Forum\DeleteThreadAction;
use App\Models\Thread;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Threads extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?int $threadToDelete = null;

    #[Computed(persist: true)]
    public function user(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    #[Computed]
    public function threads(): LengthAwarePaginator
    {
        return Thread::with('channels', 'solutionReply')
            ->scopes('withViewsCount')
            ->withCount('replies')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }

    public function confirmDelete(int $threadId): void
    {
        $this->threadToDelete = $threadId;

        Flux::modal('confirm-delete-thread')->show();
    }

    public function delete(): void
    {
        if (! $this->threadToDelete) {
            return;
        }

        /** @var Thread $thread */
        $thread = Thread::query()->findOrFail($this->threadToDelete);

        $this->authorize('delete', $thread);

        resolve(DeleteThreadAction::class)->execute($thread);

        Flux::toast(
            text: __('notifications.thread.deleted'),
            variant: 'success',
        );

        $this->threadToDelete = null;

        Flux::modal('confirm-delete-thread')->close();
    }

    public function render(): View
    {
        return view('livewire.pages.dashboard.threads');
    }
}
