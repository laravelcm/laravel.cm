<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

trait Reactable
{
    public function reactions(): MorphToMany
    {
        return $this->morphToMany(Reaction::class, 'reactable')
            ->withPivot(['responder_id', 'responder_type']);
    }

    public function getReactionsSummary(): Collection
    {
        return $this->reactions()
            ->getQuery()
            ->select('name', DB::raw('count(*) as count'))
            ->groupBy('name')
            ->get();
    }

    public function reacted(User $responder = null): bool
    {
        if (null === $responder) {
            /** @var User $responder */
            $responder = auth()->user();
        }

        return $this->reactions()
            ->where('responder_id', $responder->id)
            ->where('responder_type', get_class($responder))->exists();
    }
}
