<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function authoredBy(User $author): void
    {
        $this->user()->associate($author);

        $this->unsetRelation('author');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->user->is($user);
    }
}
