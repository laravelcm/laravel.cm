<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

final class RegisterForm extends Form
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $username = '';

    public function createUser(): void
    {
        $password = Hash::make($this->password);

        $user = User::query()->create([
            'password' => $password,
            ...$this->only(['name', 'username', 'email']),
        ]);

        $user->assignRole(UserRole::User->value);

        event(new Registered($user));
    }

    protected function rules(): array
    {
        $emailRules = ['required', 'string', 'lowercase', 'email:rfc', 'max:255', 'unique:users'];

        if (! app()->environment('testing')) {
            $emailRules = ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:users'];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRules,
            'username' => ['required', 'string', 'max:30', 'unique:users', 'lowercase'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->uncompromised()
                    ->numbers()
                    ->mixedCase(),
            ],
        ];
    }
}
