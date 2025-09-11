<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Reactable
{
    public function getReactionsSummary(): Collection
    {
        return $this->reactions()
            ->getQuery()
            ->select('name', DB::raw('count(*) as count'))
            ->groupBy('name')
            ->get();
    }

    public function reacted(?User $responder = null): bool
    {
        if (! $responder instanceof User) {
            /** @var User $responder */
            $responder = Auth::user();
        }

        return $this->reactions()
            ->where('responder_id', $responder->id)
            ->where('responder_type', get_class($responder))->exists();
    }

    /**
     * @return MorphToMany<Reaction, $this, \Illuminate\Database\Eloquent\Relations\MorphPivot>
     */
    public function reactions(): MorphToMany
    {
        return $this->morphToMany(Reaction::class, 'reactable')
            ->withPivot(['responder_id', 'responder_type']);
    }
}
