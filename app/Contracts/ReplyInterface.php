<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyInterface
{
    public function subject(): string;

    public function latestReplies(int $amount = 5): Collection;

    public function replies(): MorphMany;

    public function isConversationOld(): bool;

    public function replyAbleSubject(): string;

    public function getPathUrl(): string;
}
