<?php

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

class Article extends Model implements ReactableInterface, HasMedia, Viewable
{
    use HasAuthor,
        HasFactory,
        HasSlug,
        HasTags,
        InteractsWithMedia,
        InteractsWithViews,
        Reactable,
        RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'body',
        'slug',
        'canonical_url',
        'cover_image',
        'show_toc',
        'is_pinned',
        'is_sponsored',
        'user_id',
        'tweet_id',
        'submitted_at',
        'approved_at',
        'declined_at',
        'shared_at',
        'sponsored_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'declined_at' => 'datetime',
        'shared_at' => 'datetime',
        'sponsored_at' => 'datetime',
        'show_toc' => 'boolean',
        'is_pinned' => 'boolean',
        'is_sponsored' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'author',
    ];

    protected $removeViewsOnDelete = true;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit(strip_tags(md_to_html($this->body)), $limit);
    }

    public function originalUrl(): ?string
    {
        return $this->canonical_url;
    }

    public function canonicalUrl(): ?string
    {
        return $this->originalUrl() ?: route('articles.show', $this->slug);
    }

    public function nextArticle()
    {
        return self::published()->where('id', '>', $this->id)->orderBy('id')->first();
    }

    public function previousArticle()
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

    public function showToc()
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
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return $this->isNotSubmitted() || $this->isNotApproved();
    }

    public function isPinned(): bool
    {
        return (bool) $this->is_pinned;
    }

    public function isSponsored(): bool
    {
        return (bool) $this->is_sponsored;
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

    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->whereNotNull('submitted_at');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeNotApproved(Builder $query): Builder
    {
        return $query->whereNull('approved_at');
    }

    public function scopeAwaitingApproval(Builder $query): Builder
    {
        return $query->submitted()
            ->notApproved()
            ->notDeclined();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->submitted()
            ->approved();
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereNull('submitted_at')
                ->orWhereNull('approved_at')
                ->orWhereNotNull('declined_at');
        });
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotPinned(Builder $query): Builder
    {
        return $query->where('is_pinned', false);
    }

    public function scopeShared(Builder $query): Builder
    {
        return $query->whereNotNull('shared_at');
    }

    public function scopeNotShared(Builder $query): Builder
    {
        return $query->whereNull('shared_at');
    }

    public function scopeDeclined(Builder $query): Builder
    {
        return $query->whereNotNull('declined_at');
    }

    public function scopeNotDeclined(Builder $query): Builder
    {
        return $query->whereNull('declined_at');
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('is_pinned', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->withCount(['reactions' => function ($query) {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('reactions_count', 'desc')
            ->orderBy('submitted_at', 'desc');
    }

    public function markAsShared()
    {
        $this->update(['shared_at' => now()]);
    }

    public static function nextForSharing(): ?self
    {
        return self::notShared()
            ->published()
            ->orderBy('submitted_at', 'asc')
            ->first();
    }

    public static function nexForSharingToTelegram(): ?self
    {
        return self::shared()
            ->published()
            ->whereNull('tweet_id')
            ->orderBy('submitted_at', 'asc')
            ->first();
    }

    public function markAsPublish()
    {
        $this->update(['tweet_id' => $this->author->id]);
    }

    public function delete()
    {
        $this->removeTags();

        parent::delete();
    }
}
