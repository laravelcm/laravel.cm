<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Reactable
{
    public function getReactionsSummary(): Collection
    {
        if ($this->relationLoaded('reactions') && $this->reactions->isNotEmpty()) {
            return $this->reactions->groupBy('name')->map(fn ($group): array => [ // @phpstan-ignore-line
                'name' => $group->first()->name, // @phpstan-ignore-line
                'count' => $group->sum('count') ?: $group->count(),
            ])->values();
        }

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
     * @return MorphToMany<Reaction, $this, MorphPivot>
     */
    public function reactions(): MorphToMany
    {
        return $this->morphToMany(Reaction::class, 'reactable')
            ->withPivot(['responder_id', 'responder_type']);
    }
}
