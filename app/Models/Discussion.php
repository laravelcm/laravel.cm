<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SubscribeInterface;
use App\Models\Builders\DiscussionQueryBuilder;
use App\Traits\HasAuthor;
use App\Traits\HasReplies;
use App\Traits\HasSlug;
use App\Traits\HasSubscribers;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property bool $locked
 * @property bool $is_pinned
 * @property int $user_id
 * @property-read int $count_all_replies_with_child
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
final class Discussion extends Model implements ReactableInterface, ReplyInterface, SubscribeInterface, Viewable
{
    use HasAuthor;
    use HasFactory;
    use HasReplies;
    use HasSlug;
    use HasSubscribers;
    use HasTags;
    use InteractsWithViews;
    use Reactable;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'body',
        'slug',
        'user_id',
        'is_pinned',
        'locked',
    ];

    protected $casts = [
        'locked' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    protected $appends = [
        'count_all_replies_with_child',
    ];

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

    public function isPinned(): bool
    {
        return $this->is_pinned;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function countAllRepliesWithChild(): Attribute
    {
        return Attribute::make(
            get: function () {
                $count = $this->replies->count();

                foreach ($this->replies()->withCount('allChildReplies')->get() as $reply) {
                    /** @var Reply $reply */
                    $count += $reply->all_child_replies_count;
                }

                return $count;
            }
        );
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
