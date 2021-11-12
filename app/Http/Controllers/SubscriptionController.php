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
}
