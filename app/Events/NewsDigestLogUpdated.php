<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class NewsDigestLogUpdated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;

    /**
     * @param  'running'|'completed'|'failed'  $status
     * @param  array{count?: int, duration?: int, provider?: string, model?: string}  $result
     */
    public function __construct(
        public string $line,
        public string $status = 'running',
        public array $result = [],
    ) {}

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('news-digest'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'log.updated';
    }
}
