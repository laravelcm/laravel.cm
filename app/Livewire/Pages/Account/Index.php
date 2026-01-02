<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Actions\User\UpdateUserProfileAction;
use App\Livewire\Forms\AccountForm;
use App\Models\User;
use App\Traits\FormatSocialAccount;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

final class Index extends Component
{
    use FormatSocialAccount;
    use WithFileUploads;

    public AccountForm $form;

    public string $currentUserEmail;

    public function mount(): void
    {
        /** @var User $user */
        $user = auth()->user();

        $this->currentUserEmail = $user->email;

        $this->form->setUser($user);
    }

    public function updatedFormGithubProfile(?string $value): void
    {
        $this->form->github_profile = $this->formatGithubHandle($value);
    }

    public function updatedFormTwitterProfile(?string $value): void
    {
        $this->form->twitter_profile = $this->formatTwitterHandle($value);
    }

    public function updatedFormLinkedinProfile(?string $value): void
    {
        $this->form->linkedin_profile = $this->formatLinkedinHandle($value);
    }

    public function updatedFormBio(?string $value): void
    {
        if ($value) {
            $this->form->bio = mb_trim(strip_tags($value));
        }
    }

    public function save(): void
    {
        $this->form->validate();

        /** @var User $user */
        $user = auth()->user();

        if ($this->form->avatar instanceof TemporaryUploadedFile) {
            $user->clearMediaCollection('avatar');

            $user->addMedia($this->form->avatar->getRealPath())
                ->toMediaCollection('avatar');
        }

        resolve(UpdateUserProfileAction::class)->execute(
            data: Arr::except($this->form->toArray(), ['user', 'avatar']),
            user: $user,
            currentUserEmail: $this->currentUserEmail,
        );

        $this->currentUserEmail = $this->form->email;

        Flux::toast(
            text: __('notifications.user.profile_updated'),
            variant: 'success',
        );
    }

    public function render(): View
    {
        return view('livewire.pages.account.index')
            ->title(__('global.navigation.account'));
    }
}
