<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;

class SubscriptionController extends Controller
{
    public function unsubscribe(Subscribe $subscription)
    {
        /** @var \App\Models\Thread $thread */
        $thread = $subscription->subscribeAble;

        $thread->subscribes()->where('user_id', $subscription->user->id)->delete();

        session()->flash('status', 'Vous êtes maintenant désabonné de ce sujet.');

        return redirect()->route('forum.show', $thread->slug());
    }

    public function redirect($id, $type)
    {
        $subscribe = Subscribe::where('subscribeable_id', $id)->where('subscribeable_type', $type)->firstOrFail();

        // @phpstan-ignore-next-line
        return redirect(route_to_reply_able($subscribe->subscribeAble));
    }
}
