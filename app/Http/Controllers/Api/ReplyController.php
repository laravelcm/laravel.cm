<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CommentWasAdded;
use App\Gamify\Points\ReplyCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateReplyRequest;
use App\Http\Requests\Api\UpdateReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Discussion;
use App\Models\Reaction;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReplyController extends Controller
{
    public function all(int $target): AnonymousResourceCollection
    {
        /** @var Discussion $discussion */
        $discussion = Discussion::findOrFail($target);
        $replies = collect();

        foreach ($discussion->replies as $reply) {
            if ($reply->allChildReplies->isNotEmpty()) {
                foreach ($reply->allChildReplies as $childReply) {
                    $replies->add($childReply);
                }
            }

            $replies->add($reply);
        }

        return ReplyResource::collection($replies);
    }

    public function store(CreateReplyRequest $request): ReplyResource
    {
        $reply = new Reply(['body' => $request->body]);
        $author = User::find($request->user_id);

        $target = Discussion::find($request->target);
        $reply->authoredBy($author);
        $reply->to($target);
        $reply->save();

        $author->givePoint(new ReplyCreated($target, $author));

        // On envoie un event pour une nouvelle réponse à tous les abonnés de la discussion
        event(new CommentWasAdded($reply, $target));

        return new ReplyResource($reply);
    }

    public function update(UpdateReplyRequest $request, int $id): ReplyResource
    {
        $reply = Reply::find($id);
        $reply->update(['body' => $request->body]);

        return new ReplyResource($reply);
    }

    public function like(Request $request, int $id): ReplyResource
    {
        $reply = Reply::findOrFail($id);
        $react = Reaction::where('name', 'love')->first();
        /** @var User $user */
        $user = User::findOrFail($request->userId);

        $user->reactTo($reply, $react);

        return new ReplyResource($reply);
    }

    public function delete(int $id): JsonResponse
    {
        /** @var Reply $reply */
        $reply = Reply::findOrFail($id);

        undoPoint(new ReplyCreated($reply->replyAble, $reply->author));

        $reply->delete();

        return response()->json(['message' => 'Commentaire supprimé avec succès']);
    }
}
