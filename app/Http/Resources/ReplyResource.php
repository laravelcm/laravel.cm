<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'model_type' => $this->replyable_type,
            'model_id' => $this->replyable_id,
            'created_at' => $this->created_at->getTimestamp(),
            'author' => new UserResource($this->author),
            'replies' => $this->replyable_type === 'discussion' ? self::collection($this->replies) : null,
        ];
    }
}
