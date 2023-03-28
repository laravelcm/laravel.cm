<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Reply;
use Exception;

final class CouldNotMarkReplyAsSolution extends Exception
{
    public static function replyAbleIsNotAThread(Reply $reply): self
    {
        return new self("La réponse avec l'identifiant [{$reply->id} n'est pas lié à un thread.]");
    }
}
