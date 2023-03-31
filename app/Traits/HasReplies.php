<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReplies
{
    public function latestReplies(int $amount = 5): Collection
    {
        return $this->replies()->latest()->limit($amount)->get();
    }

    public function latestReply(): HasOne
    {
        return $this->hasOne(Reply::class)->latestOfMany();
    }

    public function deleteReplies(): void
    {
        // We need to explicitly iterate over the replies and delete them
        // separately because all related models need to be deleted.
        foreach ($this->replies()->get() as $reply) {
            $reply->delete();
        }

        $this->unsetRelation('replies');
    }

    public function solutionReplyUrl(): string
    {
        // @phpstan-ignore-next-line
        return $this->getPathUrl()."#reply-{$this->solution_reply_id}";
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function replies(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replies', 'replyable_type', 'replyable_id');
    }

    public function isConversationOld(): bool
    {
        $sixMonthsAgo = now()->subMonths(6);

        if ($reply = $this->replies()->latest()->first()) {
            /** @var $reply Reply */
            // @phpstan-ignore-next-line
            return $reply->created_at->lt($sixMonthsAgo);
        }

        // @phpstan-ignore-next-line
        return $this->created_at->lt($sixMonthsAgo);
    }
}
