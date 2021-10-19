<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordCheck implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, Auth::user()->getAuthPassword());
    }

    public function message(): string
    {
        return 'Votre mot de passe actuel est incorrect.';
    }
}