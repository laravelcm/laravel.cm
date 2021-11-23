<?php

namespace App\Events;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

class CommentWasAdded
{
    use SerializesModels;

    public function __construct(public Reply $reply, public Discussion $discussion)
    {
    }
}