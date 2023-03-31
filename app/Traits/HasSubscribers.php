<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasSubscribers
{
    /**
     * It's important to name the relationship the same as the method because otherwise
     * eager loading of the polymorphic relationship will fail on queued jobs.
     *
     * @see https://github.com/laravelio/laravel.io/issues/350
     */
    public function subscribes(): MorphMany
    {
        return $this->morphMany(Subscribe::class, 'subscribes', 'subscribeable_type', 'subscribeable_id');
    }

    public function hasSubscriber(User $user): bool
    {
        return in_array($user->id, $this->subscribes->pluck('user_id')->toArray());
    }
}
