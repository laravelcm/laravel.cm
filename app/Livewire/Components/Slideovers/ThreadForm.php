<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Forum\SubscribeToThreadAction;
use App\Events\ThreadWasCreated;
use App\Exceptions\UnverifiedUserException;
use App\Gamify\Points\ThreadCreated;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Thread;
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
final class ThreadForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;
    use WithAuthenticatedUser;

    public ?Thread $thread = null;

    public ?array $data = [];

    public function mount(?int $threadId = null): void
    {
        $this->thread = $threadId
            ? Thread::query()->findOrFail($threadId)
            : new Thread;

        $this->form->fill(array_merge(
            $this->thread->toArray(),
            ['user_id' => $this->thread->user_id ?? Auth::id()]
        ));
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id'),
                Forms\Components\TextInput::make('title')
                    ->label(__('validation.attributes.title'))
                    ->helperText(__('pages/forum.min_thread_length'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set): void {
                        $set('slug', Str::slug($state));
                    })
                    ->minLength(10),
                Forms\Components\Hidden::make('slug'),
                Forms\Components\Select::make('channels')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->searchable()
                    ->required()
                    ->minItems(1)
                    ->maxItems(3),
                Forms\Components\MarkdownEditor::make('body')
                    ->fileAttachmentsDisk('public')
                    ->toolbarButtons([
                        'attachFiles',
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
            ->model($this->thread);
    }

    public function save(): void
    {
        // @phpstan-ignore-next-line
        if (! Auth::user()->hasVerifiedEmail()) {
            throw new UnverifiedUserException(
                message: __('notifications.exceptions.unverified_user')
            );
        }

        if ($this->thread?->id) {
            $this->authorize('update', $this->thread);
        }

        $this->validate();

        $validated = $this->form->getState();

        if ($this->thread?->id) {
            $this->thread->update($validated);
            $this->form->model($this->thread)->saveRelationships();
        } else {
            $thread = Thread::query()->create($validated);
            $this->form->model($thread)->saveRelationships();

            app(SubscribeToThreadAction::class)->execute($thread);

            givePoint(new ThreadCreated($thread));
            event(new ThreadWasCreated($thread));
        }

        Notification::make()
            ->title(
                $this->thread?->id
                    ? __('notifications.thread.updated')
                    : __('notifications.thread.created'),
            )
            ->success()
            ->send();

        $this->redirect(route('forum.show', ['thread' => $thread ?? $this->thread]), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.thread-form');
    }
}
