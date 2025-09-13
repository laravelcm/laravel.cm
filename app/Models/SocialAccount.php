<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $provider
 * @property-read string $provider_id
 * @property-read int $user_id
 * @property-read string|null $token
 * @property-read string|null $avatar
 * @property-read User $user
 */
final class SocialAccount extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
