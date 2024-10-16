<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\Models\Reaction;
use App\Models\Reply;
use App\Models\User;

final class LikeReply
{
    public function handle(User $user, Reply $reply, string $reaction = 'love'): void
    {
        /** @var Reaction $react */
        $react = Reaction::query()->where('name', $reaction)->first();

        $user->reactTo($reply, $react);
    }
}
