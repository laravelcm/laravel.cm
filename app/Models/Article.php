<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Models\Builders\ArticleQueryBuilder;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLocaleScope;
use App\Models\Traits\HasPublicId;
use App\Models\Traits\HasSlug;
use App\Observers\ArticleObserver;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\CarbonInterface;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property-read int $id
 * @property-read string $public_id
 * @property-read string $title
 * @property-read string $slug
 * @property-read string $body
 * @property-read bool $show_toc
 * @property-read bool $is_pinned
 * @property-read int $is_sponsored
 * @property-read ?string $canonical_url
 * @property-read ?string $reason
 * @property-read ?int $tweet_id
 * @property-read int $user_id
 * @property-read ?string $locale
 * @property-read User $user
 * @property-read ?CarbonInterface $published_at
 * @property-read ?CarbonInterface $submitted_at
 * @property-read ?CarbonInterface $approved_at
 * @property-read ?CarbonInterface $shared_at
 * @property-read ?CarbonInterface $declined_at
 * @property-read ?CarbonInterface $sponsored_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Collection<int, Tag> $tags
 */
#[ObservedBy(ArticleObserver::class)]
final class Article extends Model implements HasMedia, ReactableInterface, Sitemapable, Viewable
{
    use HasAuthor;
    use HasFactory;
    use HasLocaleScope;
    use HasPublicId;
    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use InteractsWithViews;
    use Reactable;
    use RecordsActivity;

    protected $guarded = [];

    protected bool $removeViewsOnDelete = true;

    public static function nextForSharing(): ?self
    {
        // @phpstan-ignore-next-line
        return self::notShared()
            ->published()
            ->orderBy('published_at')
            ->first();
    }

    public static function nexForSharingToTelegram(): ?self
    {
        // @phpstan-ignore-next-line
        return self::published()
            ->whereNull('tweet_id')
            ->orderBy('published_at', 'asc')
            ->first();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function newEloquentBuilder($query): ArticleQueryBuilder
    {
        return new ArticleQueryBuilder($query);
    }

    public function toSitemapTag(): Url
    {
        return Url::create(route('articles.show', $this))
            ->setLastModificationDate(Date::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.5);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpg',
                'image/png',
                'image/webp',
                'image/avif',
            ]);
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
    }

    public function canonicalUrl(): string
    {
        return $this->canonical_url ?: route('articles.show', $this->slug);
    }

    public function nextArticle(): ?self
    {
        return self::published()->where('id', '>', $this->id)->orderBy('id')->first(); // @phpstan-ignore-line
    }

    public function previousArticle(): ?self
    {
        return self::published()->where('id', '<', $this->id)->orderByDesc('id')->first(); // @phpstan-ignore-line
    }

    public function readTime(): int
    {
        return Str::readDuration($this->body);
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
        if ($this->isNotSubmitted()) {
            return true;
        }

        return $this->isNotApproved();
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

    public function markAsShared(): void
    {
        $this->update(['shared_at' => now()]);
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

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'declined_at' => 'datetime',
            'shared_at' => 'datetime',
            'sponsored_at' => 'datetime',
            'published_at' => 'datetime',
            'show_toc' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }
}
