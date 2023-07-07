<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isEnterprise(); // @phpstan-ignore-line
    }

    public function rules(): array
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        return [
            'name' => 'required',
            'website' => 'required|unique:enterprises,website|regex:'.$regex,
            'user_id' => 'required',
        ];
    }
}
