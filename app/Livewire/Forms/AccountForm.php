<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Form;

final class AccountForm extends Form
{
    use WithFileUploads;

    public ?User $user;

    public ?TemporaryUploadedFile $avatar = null;

    public string $name = '';

    public string $username = '';

    public string $email = '';

    public ?string $bio = null;

    public ?string $website = null;

    public ?string $location = null;

    public ?string $phone_number = null;

    public ?string $github_profile = null;

    public ?string $twitter_profile = null;

    public ?string $linkedin_profile = null;

    public function setUser(User $user): void
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->bio = $user->bio;
        $this->website = $user->website;
        $this->location = $user->location;
        $this->phone_number = $user->phone_number;
        $this->github_profile = $user->github_profile;
        $this->twitter_profile = $user->twitter_profile;
        $this->linkedin_profile = $user->linkedin_profile;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:80',
            'avatar' => 'nullable|image|max:1024',
            'bio' => 'nullable|string|max:160',
            'website' => 'nullable|url',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
                'max:255',
            ],
            'github_profile' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'github_profile')->ignore($this->user),
            ],
            'twitter_profile' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'twitter_profile')->ignore($this->user),
            ],
            'linkedin_profile' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'linkedin_profile')->ignore($this->user),
            ],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'lowercase',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($this->user),
            ],
        ];
    }
}
