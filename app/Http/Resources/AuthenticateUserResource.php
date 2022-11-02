<?php

namespace App\Http\Resources;

use App\Models\IdeHelperUser;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IdeHelperUser
 */
class AuthenticateUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'bio' => $this->bio,
            'profilePhotoUrl' => $this->profile_photo_url,
            'phoneNumber' => $this->phone_number,
            'optIn' => $this->opt_in,
            'settings' => $this->settings,
            'reputation' => $this->reputation,

            'lastLoginAt' => $this->last_login_at,
            'emailVerifiedAt' => $this->email_verified_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
