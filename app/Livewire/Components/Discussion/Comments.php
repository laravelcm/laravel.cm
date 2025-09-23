<?php

declare(strict_types=1);

namespace App\Livewire\Components\Discussion;

use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use App\Actions\Discussion\CreateDiscussionReplyAction;
use App\Models\Discussion;
use App\Models\Reply;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property \Filament\Schemas\Schema $form
 */
final class Comments extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Discussion $discussion;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('body')
                    ->hiddenLabel()
                    ->placeholder(__('pages/discussion.placeholder'))
                    ->rows(3)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->validate();

        app()->call(CreateDiscussionReplyAction::class, [
            'body' => data_get($this->form->getState(), 'body'),
            'user' => Auth::user(),
            'model' => $this->discussion,
        ]);

        Notification::make()
            ->title(__('notifications.discussion.save_comment'))
            ->success()
            ->send();

        $this->dispatch('comments.change');

        $this->reset('data');
    }

    #[Computed]
    #[On('comments.change')]
    public function comments(): Collection
    {
        $replies = collect();

        // @phpstan-ignore-next-line
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
