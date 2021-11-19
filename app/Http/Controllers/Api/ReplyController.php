<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function delete()
    {

    }
}
