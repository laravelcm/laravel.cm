<?php

namespace App\Events;

use App\Models\Thread;
use Illuminate\Queue\SerializesModels;

class ThreadWasCreated
{
    use SerializesModels;

    public function __construct(public Thread $thread)
    {
    }
}
