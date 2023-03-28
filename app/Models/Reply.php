<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Traits\HasAuthor;
use App\Traits\HasReplies;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperReply
 */
class Reply extends Model implements ReactableInterface, ReplyInterface
{
    use HasAuthor;
    use HasFactory;
    use HasReplies;
    use Reactable;
    use RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'body',
    ];

    public static function boot()
    {
        parent::boot();
    }

    public function subject(): int
    {
        return $this->id;
    }

    public function replyAbleSubject(): int
    {
        return $this->id;
    }

    public function getPathUrl(): string
    {
        return "#reply-{$this->id}";
    }

    public function solutionTo(): HasOne
    {
        return $this->hasOne(Thread::class, 'solution_reply_id');
    }

    public function wasJustPublished(): bool
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body)), $limit);
    }

    public function mentionedUsers(): array
    {
        preg_match_all('/@([a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w))/', $this->body, $matches);

        return $matches[1];
    }

    public function to(ReplyInterface $replyAble)
    {
        $this->replyAble()->associate($replyAble);
    }

    public function allChildReplies(): MorphMany
    {
        return $this->replies()->with('allChildReplies')->where('replyable_type', 'reply');
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function replyAble(): MorphTo
    {
        return $this->morphTo('replyAble', 'replyable_type', 'replyable_id');
    }

    public function scopeIsSolution(Builder $builder): Builder
    {
        return $builder->has('solutionTo');
    }

    public function delete()
    {
        $this->deleteReplies();

        parent::delete();
    }
}
