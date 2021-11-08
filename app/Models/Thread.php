<?php

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Traits\HasReplies;
use App\Traits\HasSlug;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Thread extends Model implements Feedable, ReactableInterface, ReplyInterface, Viewable
{
    use HasFactory,
        HasSlug,
        HasReplies,
        InteractsWithViews,
        Prunable,
        Reactable,
        RecordsActivity;

    const FEED_PAGE_SIZE = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'body',
        'slug',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
        'last_posted_at' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'channels',
        'author',
    ];

    protected $removeViewsOnDelete = true;

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
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
        return "/forum/{$this->slug}";
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body)), $limit);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subMonths(6));
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
        return ! is_null($this->solution_reply_id);
    }

    public function wasResolvedBy(User $user): bool
    {
        if ($resolvedBy = $this->resolvedBy) {
            return $resolvedBy->is($user);
        }

        return false;
    }

    public function markSolution(Reply $reply, User $user)
    {
        $thread = $reply->replyAble;

        if (! $thread instanceof self) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->resolvedBy()->associate($user);
        $this->solutionReply()->associate($reply);
        $this->save();
    }

    public function unmarkSolution()
    {
        $this->resolvedBy()->dissociate();
        $this->solutionReply()->dissociate();
        $this->save();
    }

    public function scopeResolved(Builder $query): Builder
    {
        return $query->whereNotNull('solution_reply_id');
    }

    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->whereNull('solution_reply_id');
    }

    public function scopeForChannel(Builder $query, string $channel): Builder
    {
        return $query->whereHas('channels', function ($query) use ($channel) {
            $query->where('channels.slug', $channel);
        });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return self::feedQuery()->orderByDesc('created_at');
    }

    public function delete()
    {
        $this->channels()->delete();
        $this->deleteReplies();

        parent::delete();
    }

    public function toFeedItem(): FeedItem
    {
        $updatedAt = Carbon::parse($this->latest_creation);

        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->body)
            ->updated($updatedAt)
            ->link(route('thread', $this->slug))
            ->authorName($this->user->name);
    }

    public static function feed(int $limit = 20): Collection
    {
        return static::feedQuery()->limit($limit)->get();
    }

    public static function feedPaginated(int $perPage = 20): Paginator
    {
        return static::feedQuery()->paginate($perPage);
    }

    public static function feedByChannelPaginated(Channel $channel, int $perPage = 20): Paginator
    {
        return static::feedByChannelQuery($channel)
            ->paginate($perPage);
    }

    public static function feedByChannelQuery(Channel $channel): Builder
    {
        return static::feedQuery()
            ->join('channel_thread', function ($join) {
                $join->on('threads.id', 'channel_thread.thread_id');
            })
            ->where('channel_thread.channel_id', $channel->id);
    }

    /**
     * This will order the threads by creation date and latest reply.
     */
    public static function feedQuery(): Builder
    {
        return static::with([
            'solutionReply',
            'replies',
            'reactions',
            'replies.author',
            'channels',
            'author',
        ])
            ->leftJoin('replies', function ($join) {
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
     */
    public static function resolutionTime()
    {
        try {
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
        return static::feedQuery()
            ->paginate(static::FEED_PAGE_SIZE)
            ->getCollection();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->has('replies');
    }

    public function syncChannels(array $channels)
    {
        $this->save();
        $this->channels()->sync($channels);

        $this->unsetRelation('channels');
    }

    public function removeChannels()
    {
        $this->channels()->detach();

        $this->unsetRelation('channels');
    }
}
