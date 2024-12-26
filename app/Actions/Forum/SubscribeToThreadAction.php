<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

final class SubscribeToThreadAction
{
    public function execute(Thread $thread): void
    {
        $subscription = new Subscribe;
        $subscription->uuid = Uuid::uuid4()->toString();
        $subscription->user()->associate(Auth::user());
        $subscription->subscribeAble()->associate($thread);

        $thread->subscribes()->save($subscription);
    }
}
