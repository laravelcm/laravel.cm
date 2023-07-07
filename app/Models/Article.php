<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Traits\HasAuthor;
use App\Traits\HasSlug;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperArticle
 */
final class Article extends Model implements ReactableInterface, HasMedia, Viewable
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
        'cover_image',
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

    protected $with = [
        'media',
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

    public function showToc(): bool
    {
        return $this->show_toc;
    }

    public function submittedAt(): ?Carbon
    {
        return $this->submitted_at;
    }

    public function approvedAt(): ?Carbon
    {
        return $this->approved_at;
    }

    public function createdAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function sponsoredAt(): ?Carbon
    {
        return $this->sponsored_at;
    }

    public function publishedAt(): ?Carbon
    {
        return $this->published_at;
    }

    public function isSubmitted(): bool
    {
        return ! $this->isNotSubmitted();
    }

    public function isNotSubmitted(): bool
    {
        return null === $this->submitted_at;
    }

    public function isApproved(): bool
    {
        return ! $this->isNotApproved();
    }

    public function isNotApproved(): bool
    {
        return null === $this->approved_at;
    }

    public function isSponsored(): bool
    {
        return ! $this->isNotSponsored();
    }

    public function isNotSponsored(): bool
    {
        return null === $this->sponsored_at;
    }

    public function isDeclined(): bool
    {
        return ! $this->isNotDeclined();
    }

    public function isNotDeclined(): bool
    {
        return null === $this->declined_at;
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished() && ($this->publishedAt() && $this->publishedAt()->lessThanOrEqualTo(now()));
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
        return null === $this->shared_at;
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
        $this->update(['tweet_id' => $this->user->id]); // @phpstan-ignore-line
    }

    public function delete(): ?bool
    {
        $this->removeTags();

        return parent::delete();
    }
}
