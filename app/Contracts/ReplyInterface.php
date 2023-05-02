<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ReplyInterface
{
    public function subject(): int|string;

    public function latestReplies(int $amount = 5): Collection;

    public function replies(): MorphMany;

    public function isConversationOld(): bool;

    public function replyAbleSubject(): int|string;

    public function getPathUrl(): string;
}
