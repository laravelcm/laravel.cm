<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Actions\User\UpdateUserProfileAction;
use App\Models\User;
use App\Traits\FormatSocialAccount;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

/**
 * @property Form $form
 * @property User $user
 */
final class Profile extends Component implements HasForms
{
    use FormatSocialAccount;
    use InteractsWithForms;

    public ?array $data = [];

    public User $user;

    public string $currentUserEmail;

    public function mount(): void
    {
        $this->form->fill($this->user->toArray());

        $this->currentUserEmail = $this->user->email;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('pages/account.settings.profile_title'))
                    ->description(__('pages/account.settings.profile_description'))
                    ->aside()
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                            ->label(__('validation.attributes.avatar'))
                            ->collection('avatar')
                            ->helperText(__('pages/account.settings.avatar_description'))
                            ->image()
                            ->avatar()
                            ->maxSize(1024),
                        Forms\Components\TextInput::make('username')
                            ->label(__('validation.attributes.username'))
                            ->prefix('laravel.cm/user/@')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30)
                            ->rules(['lowercase', 'alpha_dash']),
                        Forms\Components\Textarea::make('bio')
                            ->label(__('validation.attributes.bio'))
                            ->hint(__('global.characters', ['number' => 160]))
                            ->maxLength(160)
                            ->afterStateUpdated(fn (?string $state) => trim(strip_tags((string) $state)))
                            ->helperText(__('pages/account.settings.bio_description')),
                        Forms\Components\TextInput::make('website')
                            ->label(__('validation.attributes.website'))
                            ->prefixIcon('untitledui-globe')
                            ->placeholder('https://laravel.cm')
                            ->url(),
                    ]),

                Forms\Components\Section::make(__('pages/account.settings.personal_information_title'))
                    ->description(__('pages/account.settings.personal_information_description'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('validation.attributes.last_name'))
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('validation.attributes.email'))
                            ->suffixIcon(fn () => $this->user->hasVerifiedEmail() ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                            ->suffixIconColor(fn () => $this->user->hasVerifiedEmail() ? 'success' : 'warning')
                            ->HelperText(fn () => ! $this->user->hasVerifiedEmail() ? __('pages/account.settings.unverified_mail') : null)
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\TextInput::make('location')
                            ->label(__('validation.attributes.location')),
                        PhoneInput::make('phone_number')
                            ->label(__('validation.attributes.phone')),
                    ]),

                Forms\Components\Section::make(__('pages/account.settings.social_network_title'))
                    ->description(__('pages/account.settings.social_network_description'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('github_profile')
                            ->label(__('GitHub'))
                            ->placeholder('laravelcd')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('github_profile', $this->formatGithubHandle($state)))
                            ->prefix(
                                fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                    <x-icon.github
                                        class="size-5 text-gray-400 dark:text-gray-500"
                                        aria-hidden="true"
                                    />
                                Blade))
                            ),
                        Forms\Components\TextInput::make('twitter_profile')
                            ->label(__('Twitter'))
                            ->helperText(__('pages/account.settings.twitter_helper_text'))
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('twitter_profile', $this->formatTwitterHandle($state)))
                            ->prefix(
                                fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                    <x-icon.twitter
                                        class="size-5 text-gray-400 dark:text-gray-500"
                                        aria-hidden="true"
                                    />
                                Blade))
                            ),
                        Forms\Components\TextInput::make('linkedin_profile')
                            ->label(__('LinkedIn'))
                            ->placeholder('laravelcd')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('linkedin_profile', $this->formatLinkedinHandle($state)))
                            ->prefix(
                                fn (): HtmlString => new HtmlString(Blade::render(<<<'Blade'
                                    <x-icon.linkedin
                                        class="size-5 text-gray-400 dark:text-gray-500"
                                        aria-hidden="true"
                                    />
                                Blade))
                            )
                            ->helperText(fn (): HtmlString => new HtmlString(Blade::render(
                                <<<'Blade'
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <x-filament::badge class="inline-flex" color="gray">linkedin.com/in/{votre-pseudo}</x-filament::badge>
                                        {{ __('pages/account.settings.linkedin_helper_text') }}
                                    </p>
                                Blade
                            ))),
                    ]),
            ])
            ->statePath('data')
            ->model($this->user);
    }

    public function save(): void
    {
        $this->validate();

        app(UpdateUserProfileAction::class)->execute(
            data: $this->form->getState(),
            user: $this->user,
            currentUserEmail: $this->currentUserEmail,
        );

        Notification::make()
            ->success()
            ->title(__('notifications.user.profile_updated'))
            ->duration(3500)
            ->send();

        $this->redirectRoute('settings', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.user.profile');
    }
}
