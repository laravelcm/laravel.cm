<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @mixin IdeHelperActivity
 */
final class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data',
        'subject_type',
        'subject_id',
        'type',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param User $user
     * @param int $take
     * @return array<string, \Illuminate\Support\Collection<int|string, \Illuminate\Support\Collection<int|string, Activity>>>
     */
    public static function feed(User $user, int $take = 50): array
    {
        // @phpstan-ignore-next-line
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(fn (Activity $activity) => $activity->created_at->format('Y-m-d')); // @phpstan-ignore-line
    }

    public static function latestFeed(User $user, int $take = 10): Collection
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->orderByDesc('created_at')
            ->get();
    }
}
