<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property int $user_id
 * @property array | null $data
 * @property string $subject_type
 * @property int $subject_id
 * @property string $type
 * @property User $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
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

    public static function feed(User $user, int $take = 50): Collection
    {
        return self::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(fn (Activity $activity) => $activity->created_at->format('Y-m-d'));
    }

    public static function latestFeed(User $user, int $take = 10): Collection
    {
        return self::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->orderByDesc('created_at')
            ->get();
    }
}
