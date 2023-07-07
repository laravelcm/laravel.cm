<?php

declare(strict_types=1);

namespace App\Http\Livewire\Discussions;

use App\Actions\Replies\CreateReply;
use App\Models\Discussion;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AddComment extends Component
{
    public ?Discussion $discussion;

    public bool $isRoot = true;

    public bool $isReply = false;

    public string $body = '';

    /**
     * @var string[]
     */
    protected $listeners = ['reloadComment' => '$refresh'];

    public function mount(Discussion $discussion): void
    {
        $this->discussion = $discussion;
    }

    public function saveComment(): void
    {
        $this->validate(
            ['body' => 'required'],
            ['body.required' => __('Votre commentaire ne peut pas être vide')]
        );

        $comment = CreateReply::run($this->body, auth()->user(), $this->discussion);

        $this->emitSelf('reloadComment');

        $this->emitUp('reloadComments');

        $this->dispatchBrowserEvent('scrollToComment', ['id' => $comment->id]);

        Notification::make()
            ->title(__('Votre commentaire a été ajouté!'))
            ->success()
            ->duration(5000)
            ->send();

        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.discussions.add-comment');
    }
}
