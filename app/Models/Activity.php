<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasPublicId;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property-read string $public_id
 * @property-read string $subject_type
 * @property-read int $subject_id
 * @property-read string $type
 * @property-read array<string, mixed>|null $data
 * @property-read int $user_id
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Model $subject
 * @property-read User $user
 */
final class Activity extends Model
{
    use HasFactory;
    use HasPublicId;

    protected $guarded = [];

    /**
     * @return Collection<int, Activity>
     */
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

    /**
     * @return Collection<int, Model>
     */
    public static function latestFeed(User $user, int $take = 10): Collection
    {
        return self::query()
            ->where('user_id', $user->id)
            ->with('subject')
            ->latest()
            ->limit($take)
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

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
