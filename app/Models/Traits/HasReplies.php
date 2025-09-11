<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasReplies
{
    /**
     * @return Collection<array-key, Reply>
     */
    public function latestReplies(int $amount = 5): Collection
    {
        return $this->replies()->latest()->limit($amount)->get();
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

    public function isConversationOld(): bool
    {
        $sixMonthsAgo = now()->subMonths(6);

        if ($reply = $this->replies()->latest()->first()) {
            /** @var Reply $reply */
            return $reply->created_at->lt($sixMonthsAgo);
        }

        return $this->created_at->lt($sixMonthsAgo);
    }

    /**
     * @return HasOne<Reply, $this>
     */
    public function latestReply(): HasOne
    {
        return $this->hasOne(Reply::class)->latestOfMany();
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     *
     * @return MorphMany<Reply, $this>
     */
    public function replies(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replies', 'replyable_type', 'replyable_id');
    }
}
