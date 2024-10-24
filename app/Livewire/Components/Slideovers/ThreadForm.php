<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Forum\SubscribeToThreadAction;
use App\Exceptions\UnverifiedUserException;
use App\Models\Thread;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

/**
 * @property Form $form
 */
final class ThreadForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public ?Thread $thread = null;

    public ?array $data = [];

    public function mount(?int $threadId = null): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'), navigate: true);
        }

        $this->thread = $threadId
            ? Thread::query()->findOrFail($threadId)
            : new Thread;

        $this->form->fill(array_merge($this->thread->toArray(), ['user_id' => Auth::id()]));
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id'),
                Forms\Components\TextInput::make('title')
                    ->label(__('validation.attributes.title'))
                    ->helperText(__('Maximum de 75 caractères.'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set): void {
                        $set('slug', Str::slug($state));
                    })
                    ->maxLength(75),
                Forms\Components\Hidden::make('slug'),
                Forms\Components\Select::make('channels')
                    ->relationship(name: 'channels', titleAttribute: 'name')
                    ->searchable()
                    ->required()
                    ->minItems(1)
                    ->maxItems(3)
                    ->multiple(),
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

        $this->validate();

        if ($this->thread?->id) {
            $this->authorize('update', $this->thread);
        }

        if ($this->thread?->id) {
            $this->thread->update($this->form->getState());
            $this->form->model($this->thread)->saveRelationships();
        } else {
            $thread = Thread::query()->create($this->form->getState());
            $this->form->model($thread)->saveRelationships();

            app(SubscribeToThreadAction::class)->execute($thread);
        }

        Notification::make()
            ->title(
                $this->thread?->id
                    ? __('notifications.thread.updated')
                    : __('notifications.thread.created'),
            )
            ->success()
            ->send();

        $this->dispatch('thread.save');

        $this->closePanel();

        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.thread-form');
    }
}
