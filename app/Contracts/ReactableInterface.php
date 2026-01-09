<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

interface ReactableInterface
{
    public function reactions(): MorphToMany;

    /**
     * Returns a collection of objects. Every object has a name and a count.
     *
     * Example:
     *
     *      $summaryItems = $post->getReactionsSummary();
     *      foreach($summaryItems as $reaction) {
     *          // gets the reaction name
     *          $reaction->name
     *
     *          // gets the given reactions count for the $post
     *          $reaction->count
     *      }
     */
    public function getReactionsSummary(): Collection;
}
