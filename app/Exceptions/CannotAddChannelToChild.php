<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Channel;
use Exception;

final class CannotAddChannelToChild extends Exception
{
    public static function childChannelCannotBeParent(Channel $channel): self
    {
        return new self(sprintf('Le channel [%s ne peut pas être un channel parent.]', $channel->name));
    }
}
