<?php

namespace App\Http\Resources;

use App\Models\IdeHelperReply;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IdeHelperReply
 */
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
            'experience' => $this->author->getPoints(),
            'has_replies' => $this->allChildReplies->isNotEmpty(),
            // @phpstan-ignore-next-line
            'likes_count' => $this->getReactionsSummary()->sum('count'),
        ];
    }
}
