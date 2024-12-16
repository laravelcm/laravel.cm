<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Discussion\CreateOrUpdateDiscussionAction;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Discussion;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

/**
 * @property Form $form
 */
final class DiscussionForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;
    use WithAuthenticatedUser;

    public ?Discussion $discussion = null;

    public ?array $data = [];

    public function mount(?int $discussionId = null): void
    {
        // @phpstan-ignore-next-line
        $this->discussion = $discussionId
            ? Discussion::query()->findOrFail($discussionId)
            : new Discussion;

        $this->form->fill(array_merge(
            $this->discussion->toArray(),
            ['user_id' => $this->discussion->user_id ?? Auth::id()]
        ));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id'),
                Forms\Components\TextInput::make('title')
                    ->label(__('validation.attributes.title'))
                    ->helperText(__('pages/discussion.min_discussion_length'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set): void {
                        $set('slug', Str::slug($state));
                    })
                    ->minLength(10),
                Forms\Components\Hidden::make('slug'),
                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->searchable()
                    ->required()
                    ->minItems(1)
                    ->maxItems(3),
                Forms\Components\MarkdownEditor::make('body')
                    ->fileAttachmentsDisk('public')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'link',
                    ])
                    ->label(__('validation.attributes.content'))
                    ->required()
                    ->minLength(20),
                Forms\Components\Placeholder::make('')
                    ->content(fn () => new HtmlString(Blade::render(<<<'Blade'
                        <x-torchlight />
                    Blade))),
            ])
            ->statePath('data')
            ->model($this->discussion);
    }

    /**
     * @throws UnverifiedUserException
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws \Exception
     */
    public function save(): void
    {
        // @phpstan-ignore-next-line
        if (! Auth::user()->hasVerifiedEmail()) {
            throw new UnverifiedUserException(
                message: __('notifications.exceptions.unverified_user')
            );
        }

        if ($this->discussion?->id) {
            $this->authorize('update', $this->discussion);
        }

        $this->validate();

        $validated = $this->form->getState();

        $discussion = app(CreateOrUpdateDiscussionAction::class)->handle(
            data : $validated,
            discussionId: $this->discussion?->id
        );

        $this->form->model($discussion)->saveRelationships();

        Notification::make()
            ->title(
                $this->discussion?->id
                    ? __('notifications.discussion.updated')
                    : __('notifications.discussion.created'),
            )
            ->success()
            ->send();

        // @phpstan-ignore-next-line
        $this->redirect(route('discussions.show', ['discussion' => $discussion ?? $this->discussion]), navigate: true);
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public static function closePanelOnEscape(): bool
    {
        return false;
    }

    public static function closePanelOnClickAway(): bool
    {
        return false;
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.discussion-form');
    }
}
