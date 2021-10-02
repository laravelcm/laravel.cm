<?php

namespace App\Traits;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait Reactable
{
    public function reactions()
    {
        return $this->morphToMany(Reaction::class, 'reactable')
            ->withPivot(['responder_id', 'responder_type']);
    }

    public function getReactionsSummary()
    {
        return $this->reactions()
            ->getQuery()
            ->select('name', DB::raw('count(*) as count'))
            ->groupBy('name')
            ->get();
    }

    public function reacted(User $responder = null)
    {
        if (is_null($responder)) {
            $responder = auth()->user();
        }

        return $this->reactions()
            ->where('responder_id', $responder->id)
            ->where('responder_type', get_class($responder))->exists();
    }
}
