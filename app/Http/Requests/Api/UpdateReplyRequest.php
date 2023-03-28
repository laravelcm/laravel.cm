<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\FormRequest;

class UpdateReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'body' => 'required',
        ];
    }
}
