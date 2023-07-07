<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\IdeHelperUser;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IdeHelperUser
 */
final class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'profile_photo_url' => $this->profile_photo_url,
        ];
    }
}
