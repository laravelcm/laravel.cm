<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read User $user
 */
trait HasAuthor
{
    public function authoredBy(User $author): void
    {
        $this->user()->associate($author);

        $this->unsetRelation('user');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->user->is($user);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
