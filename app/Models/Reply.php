<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SpamReportableContract;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasReplies;
use App\Traits\HasSpamReports;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\CarbonInterface;
use Database\Factories\ReplyFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property-read string $body
 * @property-read int $user_id
 * @property-read User $user
 * @property-read int $replyable_id
 * @property-read string $replyable_type
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Collection<int, SpamReport> $spamReports
 * @property-read ?Thread $solutionTo
 */
final class Reply extends Model implements ReactableInterface, ReplyInterface, SpamReportableContract
{
    use HasAuthor;

    /** @use HasFactory<ReplyFactory> */
    use HasFactory;

    use HasReplies;
    use HasSpamReports;
    use Reactable;
    use RecordsActivity;

    protected $guarded = [];

    public function subject(): int
    {
        return $this->id;
    }

    public function replyAbleSubject(): int
    {
        return $this->id;
    }

    public function getPathUrl(): string
    {
        return '#reply-'.$this->id;
    }

    public function wasJustPublished(): bool
    {
        return $this->created_at->gt(\Illuminate\Support\Facades\Date::now()->subMinute());
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
    }

    public function mentionedUsers(): array
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body, $matches);

        return $matches[1];
    }

    public function to(ReplyInterface|Model $replyable): void
    {
        $this->replyAble()->associate($replyable); // @phpstan-ignore-line
    }

    public function delete(): bool
    {
        $this->deleteReplies();

        parent::delete();

        return true;
    }

    /**
     * @return HasOne<Thread, $this>
     */
    public function solutionTo(): HasOne
    {
        return $this->hasOne(Thread::class, 'solution_reply_id');
    }

    public function allChildReplies(): MorphMany
    {
        return $this->replies()
            ->with('allChildReplies')
            ->where('replyable_type', 'reply');
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function replyAble(): MorphTo
    {
        return $this->morphTo('replyAble', 'replyable_type', 'replyable_id');
    }

    /**
     * @param  Builder<Reply>  $query
     */
    #[Scope]
    protected function isSolution(Builder $query): Builder
    {
        return $query->has('solutionTo');
    }
}
