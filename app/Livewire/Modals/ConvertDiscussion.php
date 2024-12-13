<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Models\Discussion;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

final class ConvertDiscussion extends ModalComponent
{
    public int $discussionId;

    public function save(): void
    {
        $discussion = Discussion::findOrFail($this->discussionId);

        $this->authorize('convertedToThread', $discussion);

        $thread = app(ConvertDiscussionToThreadAction::class)->execute($discussion);

        $this->redirectRoute('forum.show', $thread, navigate: true);
    }

    public function render(): View
    {
        return view('livewire.modals.convert-discussion');
    }
}
