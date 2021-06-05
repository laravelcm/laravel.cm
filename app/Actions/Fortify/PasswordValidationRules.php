<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Rules\Password::min(6)->uncompromised(),
        ];
    }
}
