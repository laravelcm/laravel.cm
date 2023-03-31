<?php

declare(strict_types=1);

namespace App\Actions\Replies;

use App\Models\Reaction;
use App\Models\Reply;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

final class LikeReply
{
    use AsAction;

    public function handle(User $user, Reply $reply, string $reaction = 'love'): void
    {
        $react = Reaction::where('name', $reaction)->first();

        $user->reactTo($reply, $react);
    }
}
