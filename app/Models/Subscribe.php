<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Database\Factories\SubscribeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read string $uuid
 * @property-read int $user_id
 * @property-read int $subscribeable_id
 * @property-read string $subscribeable_type
 * @property-read User $user
 */
final class Subscribe extends Model
{
    /** @use HasFactory<SubscribeFactory> */
    use HasFactory;

    use HasUuid;

    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function subscribeAble(): MorphTo
    {
        return $this->morphTo('subscribeAble', 'subscribeable_type', 'subscribeable_id');
    }
}
