<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Discussion\CreateOrUpdateDiscussionAction;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Forms\DiscussionFormObject;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Discussion;
use App\Models\Tag;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Livewire\Attributes\Computed;

final class DiscussionForm extends SlideOverComponent
{
    use WithAuthenticatedUser;

    public DiscussionFormObject $form;

    public ?Discussion $discussion = null;

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public static function closePanelOnClickAway(): bool
    {
        return false;
    }

    public function mount(?int $discussionId = null): void
    {
        /** @var Discussion $discussion */
        $discussion = filled($discussionId)
            ? Discussion::with('tags')->findOrFail($discussionId)
            : new Discussion;

        $this->discussion = $discussion;

        $this->form->setDiscussion($this->discussion);
    }

    #[Computed]
    public function availableTags(): Collection
    {
        return Tag::query()
            ->whereJsonContains('concerns', 'discussion')
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

        if ($this->discussion?->id) {
            $this->authorize('update', $this->discussion);
        }

        $this->form->validate();

        $discussion = resolve(CreateOrUpdateDiscussionAction::class)->handle(
            data: [
                'user_id' => $this->form->user_id,
                'title' => $this->form->title,
                'slug' => $this->form->slug,
                'locale' => $this->form->locale,
                'body' => $this->form->body,
            ],
            discussionId: $this->discussion?->id
        );

        $discussion->tags()->sync($this->form->tags);

        Flux::toast(
            text: $this->discussion?->id
                ? __('notifications.discussion.updated')
                : __('notifications.discussion.created'),
            variant: 'success'
        );

        $this->redirect(route('discussions.show', $discussion), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.discussion-form');
    }
}
