<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use App\Actions\Article\CreateArticleAction;
use App\Actions\Article\UpdateArticleAction;
use App\Data\ArticleData;
use App\Exceptions\UnverifiedUserException;
use App\Livewire\Traits\WithAuthenticatedUser;
use App\Models\Article;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

/**
 * @property-read Form $form
 */
final class ArticleForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;
    use WithAuthenticatedUser;

    public ?Article $article = null;

    public ?array $data = [];

    public function mount(?int $articleId = null): void
    {
        // @phpstan-ignore-next-line
        $this->article = filled($articleId)
            ? Article::with('tags')->findOrFail($articleId)
            : new Article;

        $this->form->fill(array_merge($this->article->toArray(), [
            'is_draft' => ! $this->article->published_at,
            'published_at' => $this->article->published_at,
            'locale' => $this->article->locale ?? app()->getLocale(),
        ]));
    }

    public static function panelMaxWidth(): string
    {
        return '6xl';
    }

    public static function closePanelOnClickAway(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('validation.attributes.title'))
                            ->minLength(10)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set): mixed => $set('slug', Str::slug($state))),
                        Forms\Components\Hidden::make('slug'),
                        Forms\Components\TextInput::make('canonical_url')
                            ->label(__('pages/article.form.canonical_url'))
                            ->helperText(__('pages/article.canonical_help')),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Toggle::make('is_draft')
                                    ->label(__('pages/article.form.draft'))
                                    ->live()
                                    ->offIcon('untitledui-check')
                                    ->onColor('success')
                                    ->onIcon('untitledui-pencil-line')
                                    ->helperText(__('pages/article.draft_help')),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('pages/article.form.published_at'))
                                    ->closeOnDateSelection()
                                    ->prefixIcon('untitledui-calendar-date')
                                    ->native(false)
                                    ->visible(fn (Forms\Get $get): bool => $get('is_draft') === false)
                                    ->required(fn (Forms\Get $get): bool => $get('is_draft') === false),
                            ]),
                    ])
                    ->columnSpan(2),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                            ->collection('media')
                            ->label(__('pages/article.form.cover'))
                            ->maxSize(1024),
                        Forms\Components\Select::make('tags')
                            ->multiple()
                            ->relationship(
                                name: 'tags',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query): Builder => $query->whereJsonContains('concerns', 'post')
                            )
                            ->preload()
                            ->required()
                            ->minItems(1)
                            ->maxItems(3),
                        Forms\Components\ToggleButtons::make('locale')
                            ->label(__('validation.attributes.locale'))
                            ->options(['en' => 'En', 'fr' => 'Fr'])
                            ->helperText(__('global.locale_help'))
                            ->grouped(),
                    ])
                    ->columnSpan(1),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\MarkdownEditor::make('body')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'italic',
                                'link',
                                'orderedList',
                                'strike',
                                'table',
                            ])
                            ->label(__('validation.attributes.content'))
                            ->fileAttachmentsDisk('public')
                            ->minLength(10)
                            ->maxHeight('20.25rem')
                            ->required(),
                        Forms\Components\Placeholder::make('')
                            ->content(fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                <x-torchlight />
                            Blade))),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(3)
            ->statePath('data')
            ->model($this->article);
    }

    public function save(): void
    {
        // @phpstan-ignore-next-line
        if (! Auth::user()->hasVerifiedEmail()) {
            throw new UnverifiedUserException(
                message: __('notifications.exceptions.unverified_user')
            );
        }

        if ($this->article?->id) {
            $this->authorize('update', $this->article);
        }

        $this->validate();

        $state = $this->form->getState();

        $publishedFields = [
            'published_at' => data_get($state, 'published_at')
                ? new Carbon(data_get($state, 'published_at'))
                : null,
            'submitted_at' => data_get($state, 'is_draft') ? null : now(),
        ];

        if ($this->article?->id) {
            $article = app(UpdateArticleAction::class)->execute(
                articleData: ArticleData::from(array_merge($state, $publishedFields)),
                article: $this->article
            );

            Notification::make()
                ->title(
                    $article->submitted_at
                        ? __('notifications.article.submitted')
                        : __('notifications.article.updated'),
                )
                ->success()
                ->send();
        } else {
            $article = app(CreateArticleAction::class)->execute(
                ArticleData::from(array_merge($state, $publishedFields))
            );

            Notification::make()
                ->title(
                    data_get($state, 'is_draft') === false
                        ? __('notifications.article.submitted')
                        : __('notifications.article.created'),
                )
                ->success()
                ->send();
        }

        $this->form->model($article)->saveRelationships();

        $this->redirect(route('articles.show', ['article' => $article]), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.article-form');
    }
}
