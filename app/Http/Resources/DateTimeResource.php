<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class DateTimeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'human' => $this->diffForHumans(),
            'dateTime' => $this->toDateTimeString(),
        ];
    }
}
