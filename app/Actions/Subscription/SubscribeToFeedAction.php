<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Models\Thread;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

final class SubscribeToFeedAction
{
    public function execute(Thread $thread): void
    {
        /** @var int $authId */
        $authId = auth()->id();

        $thread->subscribes()->create([
            'uuid' => Uuid::uuid4()->toString(),
            'user_id' => $authId,
            'subscribeable_type' => $thread->getMorphClass(),
            'subscribeable_id' => $thread->id,
        ]);

        Cache::forget(sprintf('user.%d.subscriptions', $authId));
    }
}
