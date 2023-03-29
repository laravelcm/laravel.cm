<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Http\JsonResponse;

abstract class FormRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    abstract public function rules(): array;

    public function failedValidation(Validator $validator): JsonResponse
    {
        $transformed = [];

        // @phpstan-ignore-next-line
        foreach ($validator->errors() as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0],
            ];
        }

        return response()->json([
            'errors' => $transformed,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
