<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

class ReplyWasCreated
{
    use SerializesModels;

    public function __construct(public Reply $reply)
    {
    }
}
