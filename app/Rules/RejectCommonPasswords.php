<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class RejectCommonPasswords implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ! in_array($value, [
            '123456',
            '654321',
            'test123',
            'demo123456',
            '000000',
            '111111',
            'password',
            'admin123',
        ]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('Votre mot de passe n\'est pas optimal pour cette plateforme.');
    }
}
