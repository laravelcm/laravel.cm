<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PremiumUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'image' => $this->profile_photo_url,
        ];
    }
}
