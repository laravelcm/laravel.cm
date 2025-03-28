<?php

declare(strict_types=1);

namespace QCod\Gamify;

use Illuminate\Database\Eloquent\Model;

final class Badge extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('gamify.payee_model'), 'user_badges')
            ->withTimestamps();
    }

    /**
     * Award badge to a user
     */
    public function awardTo($user): void
    {
        $this->users()->attach($user);
    }

    /**
     * Remove badge from user
     */
    public function removeFrom($user): void
    {
        $this->users()->detach($user);
    }
}
