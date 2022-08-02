<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Validation\Rules\Password|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            ! app()->environment('production') ?
                Rules\Password::min(6) :
                Rules\Password::min(6)->uncompromised(),
        ];
    }
}
