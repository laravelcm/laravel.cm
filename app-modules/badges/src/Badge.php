<?php

declare(strict_types=1);

namespace Laravelcm\Badges;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Badge extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('gamify.payee_model'), 'user_badges')
            ->withTimestamps();
    }

    /**
     * Award badge to a user
     */
    public function awardTo(User $user): void
    {
        $this->users()->attach($user);
    }

    /**
     * Remove badge from user
     */
    public function removeFrom(User $user): void
    {
        $this->users()->detach($user);
    }
}
