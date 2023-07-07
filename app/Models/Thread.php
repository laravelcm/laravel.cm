<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SubscribeInterface;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Filters\Thread\ThreadFilters;
use App\Traits\HasAuthor;
use App\Traits\HasReplies;
use App\Traits\HasSlug;
use App\Traits\HasSubscribers;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * @mixin IdeHelperThread
 */
final class Thread extends Model implements Feedable, ReactableInterface, ReplyInterface, SubscribeInterface, Viewable
{
    use HasAuthor;
    use HasFactory;
    use HasReplies;
    use HasSlug;
    use HasSubscribers;
    use InteractsWithViews;
    use Notifiable;
    use Reactable;
    use RecordsActivity;

    public const FEED_PAGE_SIZE = 20;

    protected $fillable = [
        'title',
        'body',
        'slug',
        'user_id',
    ];

    protected $casts = [
        'locked' => 'boolean',
        'last_posted_at' => 'datetime',
    ];

    protected $with = [
        'channels',
    ];

    protected bool $removeViewsOnDelete = true;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function subject(): string
    {
        return $this->title;
    }

    public function replyAbleSubject(): string
    {
        return $this->title;
    }

    public function getPathUrl(): string
    {
        return "/forum/{$this->slug()}";
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class);
    }

    public function solutionReply(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply) {
            return $solution->is($reply);
        }

        return false;
    }

    public function isSolved(): bool
    {
        return null !== $this->solution_reply_id;
    }

    public function wasResolvedBy(User $user): bool
    {
        if ($resolvedBy = $this->resolvedBy) {
            return $resolvedBy->is($user);
        }

        return false;
    }

    public function markSolution(Reply $reply, User $user): void
    {
        $thread = $reply->replyAble;

        if ( ! $thread instanceof self) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->resolvedBy()->associate($user);
        $this->solutionReply()->associate($reply);
        $this->save();
    }

    public function unmarkSolution(): void
    {
        $this->resolvedBy()->dissociate();
        $this->solutionReply()->dissociate();
        $this->save();
    }

    public function scopeForChannel(Builder $query, Channel $channel): Builder
    {
        return $query->whereHas('channels', function ($query) use ($channel): void {
            if ($channel->hasItems()) {
                $query->whereIn('channels.id', array_merge([$channel->id], $channel->items->modelKeys()));
            } else {
                $query->where('channels.slug', $channel->slug());
            }
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->feedQuery()->orderByDesc('last_posted_at');
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    public function scopeResolved(Builder $query): Builder
    {
        return $query->feedQuery()
            ->whereNotNull('solution_reply_id');
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->feedQuery()
            ->whereNull('solution_reply_id');
    }

    /**
     * Scope for filtering threads.
     *
     * @param  Builder<Thread>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  string[]  $filters
     * @return Builder<Thread>
     */
    public function scopeFilter(Builder $builder, Request $request, array $filters = []): Builder
    {
        return (new ThreadFilters($request))->add($filters)->filter($builder);
    }

    public function delete(): ?bool
    {
        $this->channels()->detach();
        $this->deleteReplies();

        parent::delete();

        return true;
    }

    public function toFeedItem(): FeedItem
    {
        $updatedAt = Carbon::parse($this->latest_creation); // @phpstan-ignore-line

        return FeedItem::create()
            ->id((string) $this->id)
            ->title($this->title)
            ->summary($this->body)
            ->updated($updatedAt)
            ->link(route('forum.show', $this->slug))
            ->authorName($this->user->name); // @phpstan-ignore-line
    }

    /**
     * This will order the threads by creation date and latest reply.
     *
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    public function scopeFeedQuery(Builder $query): Builder
    {
        return $query->with([
            'solutionReply',
            'replies',
            'reactions',
            'replies.user',
            'channels',
            'user',
        ])
            ->leftJoin('replies', function ($join): void {
                $join->on('threads.id', 'replies.replyable_id')
                    ->where('replies.replyable_type', self::class);
            })
            ->orderBy('latest_creation', 'DESC')
            ->groupBy('threads.id')
            ->select('threads.*', DB::raw('
                CASE WHEN COALESCE(MAX(replies.created_at), 0) > threads.created_at
                THEN COALESCE(MAX(replies.created_at), 0)
                ELSE threads.created_at
                END AS latest_creation
            '));
    }

    /**
     * This will calculate the average resolution time in days of all threads marked as resolved.
     *
     * @return bool|int
     */
    public static function resolutionTime(): bool|int
    {
        try {
            // @phpstan-ignore-next-line
            return static::join('replies', 'threads.solution_reply_id', '=', 'replies.id')
                ->select(DB::raw('avg(datediff(replies.created_at, threads.created_at)) as duration'))
                ->first()
                ->duration;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getFeedItems(): SupportCollection
    {
        return static::with(['reactions'])->feedQuery()
            ->paginate(static::FEED_PAGE_SIZE)
            ->getCollection();
    }

    /**
     * This will tell if the thread has any replies.
     *
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->has('replies');
    }

    /**
     * @param int[] $channels
     */
    public function syncChannels(array $channels): void
    {
        $this->save();
        $this->channels()->sync($channels);

        $this->unsetRelation('channels');
    }

    public function removeChannels(): void
    {
        $this->channels()->detach();

        $this->unsetRelation('channels');
    }
}
