<?php

namespace App\Models;

use App\Contracts\ReactableInterface;
use App\Contracts\ReplyInterface;
use App\Traits\HasAuthor;
use App\Traits\Reactable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Reply extends Model implements ReactableInterface
{
    use HasAuthor, HasFactory, Reactable, RecordsActivity;

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

    public function solutionTo(): HasOne
    {
        return $this->hasOne(Thread::class, 'solution_reply_id');
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function excerpt(int $limit = 100): string
    {
        return Str::limit(strip_tags(md_to_html($this->body)), $limit);
    }

    public function to(ReplyInterface $replyAble)
    {
        $this->replyAble()->associate($replyAble);
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
}
