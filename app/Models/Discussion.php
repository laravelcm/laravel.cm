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
use App\Models\Traits\HasReplies;
use App\Models\Traits\HasSlug;
use App\Traits\HasSpamReports;
use App\Traits\HasSubscribers;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
 * @property-read string|null $locale
 * @property-read int $user_id
 * @property-read int $count_all_replies_with_child
 * @property-read User $user
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 * @property-read Collection<array-key, SpamReport> $spamReports
 * @property-read Collection<array-key, Reply> $replies
 * @property-read Collection<array-key, Tag> $tags
 * @property-read Collection<array-key, Reaction> $reactions
 */
final class Discussion extends Model implements ReactableInterface, ReplyInterface, Sitemapable, SpamReportableContract, SubscribeInterface, Viewable
{
    use HasAuthor;
    use HasFactory;
    use HasLocaleScope;
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

    protected function casts(): array
    {
        return [
            'locked' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

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
            ->setLastModificationDate(Carbon::create($this->updated_at)) // @phpstan-ignore-line
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
}
