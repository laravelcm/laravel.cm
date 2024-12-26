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
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
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

        $this->form->fill(array_merge($this->discussion->toArray(), [
            'user_id' => $this->discussion->user_id ?? Auth::id(),
            'locale' => $this->discussion->locale ?? app()->getLocale(),
        ]));
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
                    ->relationship(
                        name: 'tags',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->whereJsonContains('concerns', 'discussion')
                    )
                    ->required()
                    ->minItems(1)
                    ->maxItems(3)
                    ->preload(),
                Forms\Components\ToggleButtons::make('locale')
                    ->label(__('validation.attributes.locale'))
                    ->options(['en' => 'En', 'fr' => 'Fr'])
                    ->helperText(__('global.locale_help'))
                    ->grouped(),
                Forms\Components\MarkdownEditor::make('body')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'link',
                    ])
                    ->label(__('validation.attributes.content'))
                    ->maxHeight('18.25rem')
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

        $discussion = app(CreateOrUpdateDiscussionAction::class)->handle(
            formValues : $this->form->getState(),
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

        $this->redirect(route('discussions.show', ['discussion' => $discussion]), navigate: true);
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
