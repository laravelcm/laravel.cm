<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SocialAccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $provider
 * @property-read string $provider_id
 * @property-read int $user_id
 * @property-read ?string $token
 * @property-read ?string $avatar
 * @property-read User $user
 */
final class SocialAccount extends Model
{
    /** @use HasFactory<SocialAccountFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
