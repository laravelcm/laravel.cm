<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Events\EmailAddressWasChanged;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

/**
 * @property Form $form
 */
final class Profil extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public string $emailAddress = '';

    public function mount(): void
    {
        $this->form->fill(Auth::user()->toArray()); // @phpstan-ignore-line
        $this->emailAddress = Auth::user()->email; // @phpstan-ignore-line
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('pages/account.settings.profile_title'))
                    ->description(__('pages/account.settings.profile_description'))
                    ->schema([
                        TextInput::make('username')
                            ->label(__('validation.attributes.username'))
                            ->prefix('laravel.cm/user/')
                            ->required(),
                        Textarea::make('bio')
                            ->label(__('validation.attributes.bio'))
                            ->rows(4)
                            ->cols(20)
                            ->helperText(__('pages/account.settings.bio_description')),
                        FileUpload::make('avatar')
                            ->label(__('validation.attributes.avatar'))
                            ->helperText(__('pages/account.settings.avatar_description'))
                            ->image()
                            ->maxSize(1024),
                        TextInput::make('website')
                            ->label(__('validation.attributes.website'))
                            ->placeholder('https://www.example.com')
                            ->url(),
                    ]),

                Section::make(__('pages/account.settings.personal_information_title'))
                    ->description(__('pages/account.settings.personal_information_description'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('validation.attributes.last_name'))
                            ->required(),
                        TextInput::make('email')
                            ->label(__('validation.attributes.email'))
                            ->email()
                            ->suffixIcon(fn () => (Auth::user()?->hasVerifiedEmail() ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle'))
                            ->suffixIconColor(fn () => (Auth::user()?->hasVerifiedEmail()) ? 'success' : 'warning')
                            ->HelperText(fn () => (! Auth::user()?->hasVerifiedEmail()) ? __('pages/account.settings.unverified_mail')
                                : '')
                            ->required(),
                        TextInput::make('location')
                            ->label(__('validation.attributes.location')),
                        PhoneInput::make('phone_number')
                            ->label(__('validation.attributes.phone')),
                    ]),

                Section::make(__('pages/account.settings.social_network_title'))
                    ->description(__('pages/account.settings.social_network_description'))
                    ->schema([
                        TextInput::make('twitter_profile')
                            ->label(__('Twitter'))
                            ->helperText(__('pages/account.settings.twitter_helper_text'))
                            ->prefix('twitter.com/'),
                        TextInput::make('github_profile')
                            ->label(__('GitHub'))
                            ->prefix('github.com/'),
                        TextInput::make('linkedin_profile')
                            ->label(__('LinkedIn'))
                            ->prefix('linkedin.com/in/'),
                    ]),
            ])
            ->statePath('data')
            ->model(Auth::user());
    }

    public function updateProfil(): void
    {
        $this->validate();
        Auth::user()->update($this->form->getState()); // @phpstan-ignore-line
        $user = Auth::user()->refresh(); // @phpstan-ignore-line
        if ($user->email !== $this->emailAddress) {
            $user->email_verified_at = null;
            $user->save();

            event(new EmailAddressWasChanged($user));
        }

        Notification::make()
            ->success()
            ->title(__('notifications.user.profile_updated'))
            ->duration(3500)
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.user.profil');
    }
}
