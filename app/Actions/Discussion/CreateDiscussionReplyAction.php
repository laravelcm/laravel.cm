<?php

declare(strict_types=1);

namespace App\Actions\Discussion;

use App\Events\CommentWasAdded;
use App\Gamify\Points\ReplyCreated;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class CreateDiscussionReplyAction
{
    public function __invoke(string $body, User $user, Model $model): Reply
    {
        $reply = new Reply(['body' => $body]);
        $reply->authoredBy($user);
        $reply->to($model); // @phpstan-ignore-line
        $reply->save();

        $user->givePoint(new ReplyCreated($model, $user));

        // On envoie un event pour une nouvelle réponse à tous les abonnés de la discussion
        event(new CommentWasAdded($reply, $model)); // @phpstan-ignore-line

        return $reply;
    }
}
