<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class ReplyWasCreated
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Reply $reply)
    {
    }
}
