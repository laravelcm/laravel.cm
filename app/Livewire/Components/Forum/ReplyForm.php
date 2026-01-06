<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Actions\Forum\CreateReplyAction;
use App\Livewire\Traits\HandlesAuthorizationExceptions;
use App\Models\Reply;
use App\Models\Thread;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class ReplyForm extends Component
{
    use HandlesAuthorizationExceptions;

    public Thread $thread;

    public ?Reply $reply = null;

    public bool $show = false;

    #[Validate('required|min:10')]
    public ?string $body = null;

    #[On('replyForm')]
    public function open(?int $replyId = null): void
    {
        $this->reset('body');
        $this->resetValidation();

        if ($replyId) {
            $this->reply = Reply::query()->find($replyId);
            $this->body = $this->reply?->body;
        }

        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->body = null;
        $this->reply = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        if ($this->reply instanceof Reply) {
            $this->updateReply();
        } else {
            $this->createReply();
        }

        $this->close();

        $this->redirectRoute('forum.show', $this->thread, navigate: true);
    }

    public function createReply(): void
    {
        $this->authorize('create', Reply::class);

        resolve(CreateReplyAction::class)->execute(
            body: (string) $this->body,
            model: $this->thread,
        );

        Flux::toast(
            text: __('notifications.reply.created'),
            variant: 'success'
        );
    }

    public function updateReply(): void
    {
        $this->authorize('update', $this->reply);

        $this->reply?->update(['body' => $this->body]);

        Flux::toast(
            text: __('notifications.reply.updated'),
            variant: 'success'
        );
    }

    public function render(): View
    {
        return view('livewire.components.forum.reply-form');
    }
}
