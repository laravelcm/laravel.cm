<?php

declare(strict_types=1);

namespace App\Livewire\Components\Forum;

use App\Actions\Forum\CreateReplyAction;
use App\Models\Reply;
use App\Models\Thread;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property Form $form
 */
final class ReplyForm extends Component implements HasForms
{
    use InteractsWithForms;

    public Thread $thread;

    public ?Reply $reply = null;

    public bool $show = false;

    public ?string $body = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    #[On('replyForm')]
    public function open(?int $replyId = null): void
    {
        $this->reply = Reply::query()->find($replyId);

        $this->form->fill(['body' => $this->reply->body ?? '']);

        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
        $this->body = null;
        $this->reply = null;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('body')
                    ->hiddenLabel()
                    ->fileAttachmentsDisk('public')
                    ->autofocus()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'link',
                    ]),
            ]);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->reply instanceof Reply) {
            $this->updateReply();
        } else {
            $this->createReply();
        }

        $this->redirectRoute('forum.show', $this->thread, navigate: true);
    }

    public function createReply(): void
    {
        $this->authorize('create', Reply::class);

        app(CreateReplyAction::class)->execute(
            body: (string) $this->body,
            model: $this->thread,
        );

        Notification::make()
            ->title(__('notifications.reply.created'))
            ->success()
            ->duration(5000)
            ->send();
    }

    public function updateReply(): void
    {
        $this->authorize('update', $this->reply);

        $this->reply?->update(['body' => $this->body]);

        Notification::make()
            ->title(__('notifications.reply.updated'))
            ->success()
            ->duration(5000)
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.forum.reply-form');
    }
}
