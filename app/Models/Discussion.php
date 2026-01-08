<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SpamReportableContract;
use App\Contracts\SubscribeInterface;
use App\Models\Builders\DiscussionQueryBuilder;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLocaleScope;
use App\Models\Traits\HasPublicId;
use App\Models\Traits\HasReplies;
use App\Models\Traits\HasSlug;
use App\Traits\HasSpamReports;
use App\Traits\HasSubscribers;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\CarbonInterface;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Database\Factories\DiscussionFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read string $slug
 * @property-read string $body
 * @property-read bool $locked
 * @property-read bool $is_pinned
 * @property-read ?string $locale
 * @property-read int $user_id
 * @property-read User $user
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Collection<int, SpamReport> $spamReports
 * @property-read Collection<int, Reply> $replies
 * @property-read Collection<int, Tag> $tags
 * @property-read Collection<int, Reaction> $reactions
 */
final class Discussion extends Model implements ReactableInterface, ReplyInterface, Sitemapable, SpamReportableContract, SubscribeInterface, Viewable
{
    use HasAuthor;

    /** @use HasFactory<DiscussionFactory> */
    use HasFactory;

    use HasLocaleScope;
    use HasPublicId;
    use HasReplies;
    use HasSlug;
    use HasSpamReports;
    use HasSubscribers;
    use HasTags;
    use InteractsWithViews;
    use Reactable;
    use RecordsActivity;

    protected $guarded = [];

    protected bool $removeViewsOnDelete = true;

    public function newEloquentBuilder($query): DiscussionQueryBuilder
    {
        return new DiscussionQueryBuilder($query);
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
        return route('discussions.show', $this);
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit(strip_tags((string) md_to_html($this->body)), $limit);
    }

    public function toSitemapTag(): Url
    {
        return Url::create(route('discussions.show', $this))
            ->setLastModificationDate(Date::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.5);
    }

    public function isPinned(): bool
    {
        return $this->is_pinned;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function lockedDiscussion(): void
    {
        $this->update(['locked' => true]);
    }

    public function delete(): ?bool
    {
        $this->removeTags();
        $this->deleteReplies();

        return parent::delete();
    }

    protected function casts(): array
    {
        return [
            'locked' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }
}
