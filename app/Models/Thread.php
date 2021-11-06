<?php

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Traits\HasReplies;
use App\Traits\HasSlug;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Thread extends Model implements ReactableInterface, ReplyInterface, Viewable
{
    use HasFactory,
        HasSlug,
        HasReplies,
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

    public function scopeResolved(Builder $query): Builder
    {
        return $query->whereNotNull('solution_reply_id');
    }

    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->whereNull('solution_reply_id');
    }

    public function delete()
    {
        $this->channels()->delete();
        $this->deleteReplies();

        parent::delete();
    }
}
