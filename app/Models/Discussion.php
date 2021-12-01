<?php

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Contracts\SubscribeInterface;
use App\Traits\HasAuthor;
use App\Traits\HasReplies;
use App\Traits\HasSlug;
use App\Traits\HasSubscribers;
use App\Traits\HasTags;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discussion extends Model implements ReactableInterface, ReplyInterface, SubscribeInterface, Viewable
{
    use HasAuthor,
        HasFactory,
        HasReplies,
        HasSubscribers,
        HasSlug,
        HasTags,
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
        'user_id',
        'is_pinned',
        'locked',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'author',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        'replies',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'count_all_replies_with_child',
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
        return "/discussions/{$this->slug()}";
    }

    public function excerpt(int $limit = 110): string
    {
        return Str::limit(strip_tags(md_to_html($this->body)), $limit);
    }

    public function isPinned(): bool
    {
        return $this->is_pinned;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function getCountAllRepliesWithChildAttribute(): int
    {
        $count = $this->replies()->count();

        foreach ($this->replies()->withCount('allChildReplies')->get() as $reply) {
            $count += $reply->all_child_replies_count;
        }

        return $count;
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotPinned(Builder $query): Builder
    {
        return $query->where('is_pinned', false);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('reactions')
            ->orderBy('reactions_count', 'desc');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->withCount(['replies' => function ($query) {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('replies_count', 'desc');
    }

    public function scopeNoComments(Builder $query): Builder
    {
        return $query->whereDoesntHave('replies')
            ->orderByDesc('created_at');
    }

    public function lockedDiscussion()
    {
        $this->update(['locked' => true]);
    }

    public function delete()
    {
        $this->removeTags();
        $this->deleteReplies();

        parent::delete();
    }
}
