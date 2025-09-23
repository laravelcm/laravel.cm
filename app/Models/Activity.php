<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\ActivityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $subject_type
 * @property int $subject_id
 * @property string $type
 * @property array|null $data
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Model $subject
 * @property-read User $user
 *
 * @method static ActivityFactory factory($count = null, $state = [])
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereData($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereSubjectId($value)
 * @method static Builder|Activity whereSubjectType($value)
 * @method static Builder|Activity whereType($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity whereUserId($value)
 *
 * @mixin Model
 */
final class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public static function feed(User $user, int $take = 50): Collection
    {
        return self::query()
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(fn (Activity $activity): string => $activity->created_at->format('Y-m-d'));
    }

    public static function latestFeed(User $user, int $take = 10): Collection
    {
        return self::query()
            ->where('user_id', $user->id)
            ->with('subject')
            ->latest()
            ->limit($take)
            ->orderByDesc('created_at')
            ->get();
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
