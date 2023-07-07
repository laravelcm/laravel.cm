<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Thread;
use Illuminate\Queue\SerializesModels;

final class ThreadWasCreated
{
    use SerializesModels;

    public function __construct(public Thread $thread)
    {
    }
}
