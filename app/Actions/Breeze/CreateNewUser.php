<?php

declare(strict_types=1);

namespace App\Actions\Breeze;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Breeze\PasswordValidationRules;

final class CreateNewUser
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'username' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'alpha_dash',
                Rule::unique(User::class, 'username'),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => Str::lower($input['username']),
            'password' => Hash::make($input['password']),
            'opt_in' => isset($input['opt_in']),
        ]);

        $user->assignRole('user');

        return $user;
    }
}
