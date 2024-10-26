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
                Forms\Components\Placeholder::make('')
                    ->content(fn () => new HtmlString(Blade::render(<<<'Blade'
                        <p class="-mt-2 text-sm leading-5 text-gray-500 dark:text-gray-400">
                            {{ __('pages/forum.torchlight') }}
                            <a href="https://torchlight.dev/docs/overview" target="_blank" class="font-medium text-primary-600 underline hover:text-primary-500">
                                Torchlight
                            </a>
                        </p>
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

        $this->dispatch('thread.save');

        $this->closePanel();

        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.thread-form');
    }
}
