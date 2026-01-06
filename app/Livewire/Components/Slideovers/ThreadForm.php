<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Forum\CreateThreadAction;
use App\Actions\Forum\UpdateThreadAction;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Forms\ThreadFormObject;
use App\Livewire\Traits\HandlesAuthorizationExceptions;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;

final class ThreadForm extends SlideOverComponent
{
    use HandlesAuthorizationExceptions;
    use WithAuthenticatedUser;

    public ThreadFormObject $form;

    public ?Thread $thread = null;

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public static function closePanelOnClickAway(): bool
    {
        return false;
    }

    public function mount(?int $threadId = null): void
    {
        /** @var Thread $thread */
        $thread = filled($threadId)
            ? Thread::with('channels')->findOrFail($threadId)
            : new Thread;

        $this->thread = $thread;

        $this->form->setThread($this->thread);
    }

    #[Computed]
    public function availableChannels(): Collection
    {
        return Channel::query()
            ->orderBy('name')
            ->get();
    }

    public function updatedFormTitle(string $value): void
    {
        $this->form->slug = Str::slug($value);
    }

    public function save(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            throw new UnverifiedUserException(
                message: __('notifications.exceptions.unverified_user')
            );
        }

        if ($this->thread?->id) {
            $this->authorize('update', $this->thread);
        }

        $this->form->validate();

        $data = [
            'user_id' => $this->form->user_id,
            'title' => $this->form->title,
            'slug' => $this->form->slug,
            'locale' => $this->form->locale,
            'body' => $this->form->body,
        ];

        $thread = ($this->thread?->id)
            ? resolve(UpdateThreadAction::class)->execute($data, $this->thread)
            : resolve(CreateThreadAction::class)->execute($data);

        $thread->channels()->sync($this->form->channels);

        Flux::toast(
            text: $this->thread?->id
                ? __('notifications.thread.updated')
                : __('notifications.thread.created'),
            variant: 'success'
        );

        $this->redirect(route('forum.show', $thread), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.thread-form');
    }
}
