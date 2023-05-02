<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class PasswordCheck implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, Auth::user()->getAuthPassword()); // @phpstan-ignore-line
    }

    public function message(): string
    {
        return __('Votre mot de passe actuel est incorrect.');
    }
}
