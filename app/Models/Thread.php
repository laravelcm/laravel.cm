<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SpamReportableContract;
use App\Contracts\SubscribeInterface;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Filters\Thread\ThreadFilters;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLocaleScope;
use App\Models\Traits\HasReplies;
use App\Models\Traits\HasSlug;
use App\Traits\HasSpamReports;
use App\Traits\HasSubscribers;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Database\Factories\ThreadFactory;
use Exception;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $user_id
 * @property int $solution_reply_id
 * @property bool $locked
 * @property string | null $locale
 * @property Carbon | null $last_posted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int | null $resolved_by
 * @property User | null $resolvedBy
 * @property User $user
 * @property Reply | null $solutionReply
 * @property \Illuminate\Database\Eloquent\Collection | Channel[] $channels
 * @property \Illuminate\Database\Eloquent\Collection | Reply[] $replies
 */
final class Thread extends Model implements Feedable, ReactableInterface, ReplyInterface, SpamReportableContract, SubscribeInterface, Viewable
{
    use HasAuthor;

    /** @use HasFactory<ThreadFactory> */
    use HasFactory;
    use HasLocaleScope;
    use HasReplies;
    use HasSlug;
    use HasSpamReports;
    use HasSubscribers;
    use InteractsWithViews;
    use Notifiable;
    use Reactable;
    use RecordsActivity;

    public const int FEED_PAGE_SIZE = 20;

    protected $guarded = [];

    protected bool $removeViewsOnDelete = true;

    protected function casts(): array
    {
        return [
            'locked' => 'boolean',
            'last_posted_at' => 'datetime',
        ];
    }

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
        return route('forum.show', $this->slug);
    }

    public function excerpt(int $limit = 200): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
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
        return filled($this->solution_reply_id);
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

        if (! $thread instanceof self) {
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

    public function delete(): bool
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
            ->authorName($this->user->name);
    }

    /**
     * This will calculate the average resolution time in days of all threads marked as resolved.
     */
    public static function resolutionTime(): bool|int
    {
        try {
            // @phpstan-ignore-next-line
            return self::query()
                ->join('replies', 'threads.solution_reply_id', '=', 'replies.id')
                ->select(DB::raw('avg(datediff(replies.created_at, threads.created_at)) as duration'))
                ->first()
                ->duration;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getFeedItems(): SupportCollection
    {
        return self::with(['reactions'])->feedQuery()
            ->paginate(self::FEED_PAGE_SIZE)
            ->getCollection();
    }

    /**
     * @param  int[]  $channels
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

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    #[Scope]
    protected function channel(Builder $query, Channel $channel): Builder
    {
        return $query->whereHas('channels', function ($query) use ($channel): void {
            if ($channel->hasItems()) {
                $query->whereIn('channels.id', array_merge([$channel->id], $channel->items->modelKeys())); // @phpstan-ignore-line
            } else {
                $query->where('channels.slug', $channel->slug);
            }
        });
    }

    /**
     * @param  Builder<Thread>  $query
     */
    #[Scope]
    protected function recent(Builder $query): void
    {
        $query->feedQuery()->orderByDesc('last_posted_at');
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    #[Scope]
    protected function resolved(Builder $query): Builder
    {
        return $query->whereNotNull('solution_reply_id');
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    #[Scope]
    protected function unresolved(Builder $query): Builder
    {
        return $query->whereNull('solution_reply_id');
    }

    /**
     * @param  Builder<Thread>  $builder
     * @param  string[]  $filters
     * @return Builder<Thread>
     */
    #[Scope]
    protected function filter(Builder $builder, Request $request, array $filters = []): Builder
    {
        return new ThreadFilters($request)->add($filters)->filter($builder);
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->whereHas('replies');
    }

    /**
     * @param  Builder<Thread>  $query
     * @return Builder<Thread>
     */
    #[Scope]
    protected function feedQuery(Builder $query): Builder
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
                CASE WHEN COALESCE(MAX(replies.created_at), threads.created_at) > threads.created_at
                THEN COALESCE(MAX(replies.created_at), threads.created_at)
                ELSE threads.created_at
                END AS latest_creation
            '));
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * @return BelongsToMany<Channel, $this, Pivot>
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class);
    }

    /**
     * @return BelongsTo<Reply, $this>
     */
    public function solutionReply(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }
}
