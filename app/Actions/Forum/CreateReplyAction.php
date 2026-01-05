<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Contracts\ReplyInterface;
use App\Events\ReplyWasCreated;
use App\Gamify\Points\ReplyCreated;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class CreateReplyAction
{
    public function execute(string $body, ReplyInterface|Reply $model): void
    {
        /** @var User $user */
        $user = Auth::user();

        $reply = new Reply(['body' => $body]);
        $reply->authoredBy($user);
        $reply->to($model);
        $reply->save();

        givePoint(new ReplyCreated($reply, $user));

        event(new ReplyWasCreated($reply));
    }
}
