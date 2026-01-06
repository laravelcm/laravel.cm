<?php

declare(strict_types=1);

namespace App\Actions\Forum;

use App\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

final class SubscribeToThreadAction
{
    public function execute(Thread $thread): void
    {
        $thread->subscribes()->create([
            'uuid' => Uuid::uuid4()->toString(),
            'user_id' => Auth::id(),
            'subscribeable_type' => $thread->getMorphClass(),
            'subscribeable_id' => $thread->id,
        ]);
    }
}
