<?php

declare(strict_types=1);

namespace App\Livewire\Components\Discussion;

use App\Actions\Discussion\CreateDiscussionReplyAction;
use App\Models\Discussion;
use App\Models\Reply;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

final class Comments extends Component
{
    public Discussion $discussion;

    public string $body = '';

    public function save(): void
    {
        $this->validate([
            'body' => ['required', 'string', 'min:1'],
        ]);

        app()->call(CreateDiscussionReplyAction::class, [
            'body' => $this->body,
            'user' => Auth::user(),
            'model' => $this->discussion,
        ]);

        Flux::toast(
            text: __('notifications.discussion.save_comment'),
            variant: 'success'
        );

        $this->dispatch('comments.change');

        $this->js('$wire.body = ""');
    }

    #[Computed]
    #[On('comments.change')]
    public function comments(): Collection
    {
        $replies = collect();

        foreach ($this->discussion->replies->load(['allChildReplies', 'user', 'user.media']) as $reply) {
            /** @var Reply $reply */
            if ($reply->allChildReplies->isNotEmpty()) {
                foreach ($reply->allChildReplies as $childReply) {
                    $replies->add($childReply);
                }
            }

            $replies->add($reply);
        }

        return $replies;
    }

    public function render(): View
    {
        return view('livewire.components.discussion.comments');
    }
}
