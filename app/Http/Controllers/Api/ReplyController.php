<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Models\Discussion;
use App\Models\Reaction;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function all(int $target): AnonymousResourceCollection
    {
        /** @var Discussion $discussion */
        $discussion = Discussion::findOrFail($target);

        return ReplyResource::collection($discussion->replies);
    }

    public function store()
    {

    }

    public function update()
    {

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
        $reply->delete();

        return response()->json(['message' => 'Commentaire supprimé avec succès']);
    }
}
