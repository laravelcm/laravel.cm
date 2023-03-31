<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

final class CommentWasAdded
{
    use SerializesModels;

    public function __construct(public readonly Reply $reply, public readonly Discussion $discussion)
    {
    }
}
