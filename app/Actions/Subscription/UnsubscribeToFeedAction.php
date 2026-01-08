<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Models\Subscribe;
use Illuminate\Support\Facades\Cache;

final class UnsubscribeToFeedAction
{
    public function execute(string $subscribeId): void
    {
        Subscribe::query()
            ->where('uuid', $subscribeId)
            ->delete();

        /** @var int $authId */
        $authId = auth()->id();

        Cache::forget(sprintf('user.%d.subscriptions', $authId));
    }
}
