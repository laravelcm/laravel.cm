<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class PremiumUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'image' => $this->profile_photo_url,
        ];
    }
}
