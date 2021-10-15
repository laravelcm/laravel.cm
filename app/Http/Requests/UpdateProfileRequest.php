<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class UpdateProfileRequest extends FormRequest
{
    use ValidatesMedia;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'username' => 'required|alpha_dash|max:255|unique:users,username,' . Auth::id(),
            'twitter_profile' => 'max:255|nullable|unique:users,twitter_profile,' . Auth::id(),
            'github_profile' => 'max:255|nullable|unique:users,github_profile,' . Auth::id(),
            'bio' => 'max:160',
            'avatar' => $this->validateSingleMedia()
                ->extension(['png', 'jpg', 'jpeg'])
                ->maxItemSizeInKb(1024),
        ];
    }
}
