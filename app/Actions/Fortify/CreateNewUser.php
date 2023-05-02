<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input<string, string>
     * @return \App\Models\User
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        /** @var User $user */
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
