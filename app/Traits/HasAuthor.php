<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function authoredBy(User $author): void
    {
        $this->author()->associate($author);

        $this->unsetRelation('author');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author->is($user);
    }
}
