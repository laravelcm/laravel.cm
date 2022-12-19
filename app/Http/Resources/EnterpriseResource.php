<?php

namespace App\Http\Resources;

use App\Models\IdeHelperEnterprise;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IdeHelperEnterprise
 */
class EnterpriseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'website' => $this->website,
            'description' => $this->description,
            'about' => $this->about,
            'foundedIn' => $this->founded_in,
            'ceo' => $this->ceo,
            'isCertified' => $this->is_certified,
            'isPublic' => $this->is_public,
            'size' => $this->size,
            'settings' => $this->settings,
            'createdAt' => DateTimeResource::make($this->created_at),
            'updatedAt' => DateTimeResource::make($this->updated_at),
        ];
    }
}
