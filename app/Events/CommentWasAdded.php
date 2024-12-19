<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Queue\SerializesModels;

final readonly class CommentWasAdded
{
    use SerializesModels;

    public function __construct(public Reply $reply, public Discussion $discussion) {}
}
