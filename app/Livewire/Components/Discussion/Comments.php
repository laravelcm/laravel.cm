<?php

declare(strict_types=1);

namespace App\Livewire\Components\Discussion;

use App\Actions\Discussion\CreateDiscussionReplyAction;
use App\Models\Discussion;
use App\Models\Reply;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property Form $form
 */
final class Comments extends Component implements HasForms
{
    use InteractsWithForms;

    public Discussion $discussion;

    public ?array $data = [];

    public Collection $users;

    public string $query = '';

    public bool $showSuggestions = false;

    public Collection $mentionables;

    public function mount(): void
    {
        $this->form->fill();

        $this->mentionables = $this->users = $this->discussion
            ->replies()
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id')
            ->map(fn ($user) => [
                'id' => $user->id,
                'key' => $user->name,
                'username' => $user->username,
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')
                    ->hiddenLabel()
                    ->placeholder(__('pages/discussion.placeholder'))
                    ->rows(3)
                    ->required()
                    ->debounce()
                    ->extraAttributes(['x-ref' => 'textarea'])
                    ->afterStateUpdated(function ($state, callable $set): void {

                        if ($state) {
                            $this->query = $state;
                            $this->searchUsers($this->query);
                        }

                    }),
            ])
            ->statePath('data');
    }

    public function searchUsers(string $query): void
    {
        if (str_contains($query, '@')) {
            $mention = explode('@', $query);
            $search = end($mention);

            $this->users = $this->mentionables->filter(fn ($user) => str_contains(strtolower($user['key']), strtolower($search)) ||
                    str_contains(strtolower($user['username']), strtolower($search)));

            if ($this->users->isNotEmpty()) {
                $this->showSuggestions = true;
                $this->dispatch('showSuggestionEvent');
            }

        } else {
            $this->users = collect([]);
            $this->showSuggestions = false;
        }

    }

    #[On('setBodyForm')]
    public function setBodyForm(?string $query): void
    {
        $this->form->fill(['body' => $query]);
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
        foreach ($this->discussion->replies->load(['allChildReplies', 'user']) as $reply) {
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
        return view('livewire.components.discussion.comments')->with([
            'users' => $this->users,
        ]);
    }
}
