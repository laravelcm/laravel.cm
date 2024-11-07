<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Traits\HasAuthor;
use App\Traits\HasSlug;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string | null $canonical_url
 * @property bool $show_toc
 * @property bool $is_pinned
 * @property int $is_sponsored
 * @property int | null $tweet_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $shared_at
 * @property \Illuminate\Support\Carbon|null $declined_at
 * @property \Illuminate\Support\Carbon|null $sponsored_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activity
 * @property-read int|null $activity_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
 * @property-read int|null $reactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \CyrildeWit\EloquentViewable\View> $views
 * @property-read int|null $views_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Article approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Article awaitingApproval()
 * @method static \Illuminate\Database\Eloquent\Builder|Article declined()
 * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Article forTag(string $tag)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article notApproved()
 * @method static \Illuminate\Database\Eloquent\Builder|Article notDeclined()
 * @method static \Illuminate\Database\Eloquent\Builder|Article notPinned()
 * @method static \Illuminate\Database\Eloquent\Builder|Article notPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Article notShared()
 * @method static \Illuminate\Database\Eloquent\Builder|Article orderByUniqueViews(string $direction = 'desc', $period = null, ?string $collection = null, string $as = 'unique_views_count')
 * @method static \Illuminate\Database\Eloquent\Builder|Article orderByViews(string $direction = 'desc', ?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
 * @method static \Illuminate\Database\Eloquent\Builder|Article pinned()
 * @method static \Illuminate\Database\Eloquent\Builder|Article popular()
 * @method static \Illuminate\Database\Eloquent\Builder|Article published()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article recent()
 * @method static \Illuminate\Database\Eloquent\Builder|Article shared()
 * @method static \Illuminate\Database\Eloquent\Builder|Article sponsored()
 * @method static \Illuminate\Database\Eloquent\Builder|Article submitted()
 * @method static \Illuminate\Database\Eloquent\Builder|Article trending()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeclinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsSponsored($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSharedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereShowToc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSponsoredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTweetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article withViewsCount(?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
 */
final class Article extends Model implements HasMedia, ReactableInterface, Viewable
{
    use HasAuthor;
    use HasFactory;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use InteractsWithViews;
    use Reactable;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'body',
        'slug',
        'canonical_url',
        'show_toc',
        'is_pinned',
        'user_id',
        'tweet_id',
        'submitted_at',
        'approved_at',
        'declined_at',
        'shared_at',
        'sponsored_at',
        'published_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'declined_at' => 'datetime',
        'shared_at' => 'datetime',
        'sponsored_at' => 'datetime',
        'published_at' => 'datetime',
        'show_toc' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    protected bool $removeViewsOnDelete = true;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
    }

    public function originalUrl(): ?string
    {
        return $this->canonical_url;
    }

    public function canonicalUrl(): ?string
    {
        return $this->originalUrl() ?: route('articles.show', $this->slug);
    }

    public function nextArticle(): ?Article
    {
        return self::published()->where('id', '>', $this->id)->orderBy('id')->first();
    }

    public function previousArticle(): ?Article
    {
        return self::published()->where('id', '<', $this->id)->orderByDesc('id')->first();
    }

    public function readTime(): int
    {
        return Str::readDuration($this->body);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
    }

    public function isSubmitted(): bool
    {
        return ! $this->isNotSubmitted();
    }

    public function isNotSubmitted(): bool
    {
        return $this->submitted_at === null;
    }

    public function isApproved(): bool
    {
        return ! $this->isNotApproved();
    }

    public function isNotApproved(): bool
    {
        return $this->approved_at === null;
    }

    public function isSponsored(): bool
    {
        return ! $this->isNotSponsored();
    }

    public function isNotSponsored(): bool
    {
        return $this->sponsored_at === null;
    }

    public function isDeclined(): bool
    {
        return ! $this->isNotDeclined();
    }

    public function isNotDeclined(): bool
    {
        return $this->declined_at === null;
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished() && ($this->published_at && $this->published_at->lessThanOrEqualTo(now()));
    }

    public function isNotPublished(): bool
    {
        return $this->isNotSubmitted() || $this->isNotApproved();
    }

    public function isPinned(): bool
    {
        return $this->is_pinned;
    }

    public function isNotShared(): bool
    {
        return $this->shared_at === null;
    }

    public function isShared(): bool
    {
        return ! $this->isNotShared();
    }

    public function isAwaitingApproval(): bool
    {
        return $this->isSubmitted() && $this->isNotApproved() && $this->isNotDeclined();
    }

    public function isNotAwaitingApproval(): bool
    {
        return ! $this->isAwaitingApproval();
    }

    /**
     * Scope a query to return submitted posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->whereNotNull('submitted_at');
    }

    /**
     * Scope a query to return approved posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Scope a query to return not approved posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeNotApproved(Builder $query): Builder
    {
        return $query->whereNull('approved_at');
    }

    /**
     * Scope a query to return only posts on awaiting approval.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeAwaitingApproval(Builder $query): Builder
    {
        return $query->submitted()
            ->notApproved()
            ->notDeclined();
    }

    /**
     * Scope a query to return only published posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereDate('published_at', '<=', now())
            ->submitted()
            ->approved();
    }

    /**
     * Scope a query to return unpublished posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where(function ($query): void {
            $query->whereNull('submitted_at')
                ->orWhereNull('approved_at')
                ->orWhereNull('published_at')
                ->orWhereNotNull('declined_at');
        });
    }

    /**
     * Scope a query to return only pinned posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope a query to return unpinned posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeNotPinned(Builder $query): Builder
    {
        return $query->where('is_pinned', false);
    }

    /**
     * Scope a query to return shared posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeShared(Builder $query): Builder
    {
        return $query->whereNotNull('shared_at');
    }

    /**
     * Scope a query to return not shared posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeNotShared(Builder $query): Builder
    {
        return $query->whereNull('shared_at');
    }

    /**
     * Scope a query to return only declined posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeDeclined(Builder $query): Builder
    {
        return $query->whereNotNull('declined_at');
    }

    /**
     * Scope a query to return sponsored posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeSponsored(Builder $query): Builder
    {
        return $query->whereNotNull('sponsored_at');
    }

    /**
     * Scope a query to return not declined posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeNotDeclined(Builder $query): Builder
    {
        return $query->whereNull('declined_at');
    }

    /**
     * Scope a query to return recent posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')
            ->orderByDesc('created_at');
    }

    /**
     * Scope a query to return popular posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to return trending posts.
     *
     * @param  Builder<Article>  $query
     * @return Builder<Article>
     */
    public function scopeTrending(Builder $query): Builder
    {
        return $query->withCount(['reactions' => function ($query): void {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('reactions_count', 'desc')
            ->orderBy('published_at', 'desc');
    }

    public function markAsShared(): void
    {
        $this->update(['shared_at' => now()]);
    }

    public static function nextForSharing(): ?self
    {
        return self::notShared()
            ->published()
            ->orderBy('published_at')
            ->first();
    }

    public static function nexForSharingToTelegram(): ?self
    {
        return self::published()
            ->whereNull('tweet_id')
            ->orderBy('published_at', 'asc')
            ->first();
    }

    public function markAsPublish(): void
    {
        $this->update(['tweet_id' => $this->user->id]);
    }

    public function delete(): ?bool
    {
        $this->removeTags();

        return parent::delete();
    }
}
