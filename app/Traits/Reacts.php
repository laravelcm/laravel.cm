<?php

declare(strict_types=1);

namespace App\Traits;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;

trait Reacts
{
    public function reactTo(ReactableInterface $reactable, Reaction $reaction): ?Reaction
    {
        $reactedToReaction = $reactable->reactions()
            ->where('responder_id', $this->getKey())
            ->where('responder_type', get_class($this))->first();

        $currentReactedName = '';

        if ($reactedToReaction) {
            /** @var Reaction $reactedToReaction */
            $currentReactedName = $reactedToReaction->name;
            $this->deleteReaction($reactable, $reactedToReaction);
        }

        $reacted = $reactable->reactions()->where([
            'responder_id' => $this->getKey(),
        ])->first();

        if ( ! $reacted && ($currentReactedName !== $reaction->name)) {
            return $this->storeReaction($reactable, $reaction);
        }

        return null;
    }

    public function hasReaction(ReactableInterface $reactable): bool
    {
        // @phpstan-ignore-next-line
        return $reactable->reacted();
    }

    protected function storeReaction(ReactableInterface $reactable, Reaction $reaction): Reaction
    {
        $reactable->reactions()->attach(
            $reaction->id,
            [
                'responder_id' => $this->getKey(),
                'responder_type' => get_class($this),
            ]
        );

        return $reaction;
    }

    protected function deleteReaction(ReactableInterface $reactable, Reaction $reacted): void
    {
        $reactable->reactions()
            ->wherePivot('reaction_id', $reacted->id)
            ->wherePivot('responder_id', $this->id)
            ->wherePivot('responder_type', get_class($this))
            ->detach();
    }
}
