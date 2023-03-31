<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\RedirectResponse;

final class SubscriptionController extends Controller
{
    public function unsubscribe(Subscribe $subscription): RedirectResponse
    {
        /** @var \App\Models\Thread $thread */
        $thread = $subscription->subscribeAble;

        $thread->subscribes()->where('user_id', $subscription->user->id)->delete(); // @phpstan-ignore-line

        session()->flash('status', __('Vous êtes maintenant désabonné de ce sujet.'));

        return redirect()->route('forum.show', $thread->slug());
    }

    public function redirect(int $id, string $type): RedirectResponse
    {
        $subscribe = Subscribe::where('subscribeable_id', $id)->where('subscribeable_type', $type)->firstOrFail();

        return redirect(route_to_reply_able($subscribe->subscribeAble));
    }
}
