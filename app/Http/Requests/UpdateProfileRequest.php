<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
            'username' => 'required|alpha_dash|max:255|unique:users,username,'.Auth::id(),
            'twitter_profile' => 'max:255|nullable|unique:users,twitter_profile,'.Auth::id(),
            'github_profile' => 'max:255|nullable|unique:users,github_profile,'.Auth::id(),
            'bio' => 'nullable|max:160',
            'website' => 'nullable|url',
        ];
    }
}
