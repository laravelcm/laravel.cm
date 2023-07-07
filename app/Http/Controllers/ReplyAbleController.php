<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\RedirectResponse;

final class ReplyAbleController extends Controller
{
    public function redirect(int $id, string $type): RedirectResponse
    {
        $reply = Reply::where('replyable_id', $id)->where('replyable_type', $type)->firstOrFail();

        return redirect(route_to_reply_able($reply->replyAble));
    }
}
