<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Models\Reaction;
use App\Models\Reply;
use App\Models\User;

final class LikeReplyAction
{
    public function __invoke(User $user, Reply $reply, string $reaction = 'love'): void
    {
        /** @var Reaction $react */
        $react = Reaction::query()->where('name', $reaction)->first();

        $user->reactTo($reply, $react);
    }
}
