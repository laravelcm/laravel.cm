<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Channel;
use Exception;

final class CannotAddChannelToChild extends Exception
{
    public static function childChannelCannotBeParent(Channel $channel): self
    {
        return new self("Le channel [{$channel->name} ne peut pas être un channel parent.]");
    }
}
