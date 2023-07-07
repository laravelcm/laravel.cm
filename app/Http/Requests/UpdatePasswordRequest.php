<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\PasswordCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

final class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => ['sometimes', 'required', new PasswordCheck()],
            'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
        ];
    }
}
