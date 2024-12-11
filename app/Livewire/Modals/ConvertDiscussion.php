<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

final class ConvertDiscussion extends ModalComponent
{
    public int $discussionId;

    public function save(): void
    {
        $discussion = Discussion::findOrFail($this->discussionId);

        $this->authorize('convertedToThread', $discussion);

        $thread = app(ConvertDiscussionToThreadAction::class)->execute($discussion, Auth::user()->isAdmin());

        $this->redirectRoute('forum.show', $thread, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.modals.convert-discussion');
    }
}
