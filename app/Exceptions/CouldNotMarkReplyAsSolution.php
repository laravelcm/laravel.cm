<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Reply;
use Exception;

final class CouldNotMarkReplyAsSolution extends Exception
{
    public static function replyAbleIsNotAThread(Reply $reply): self
    {
        return new self(sprintf("La réponse avec l'identifiant [%d n'est pas lié à un thread.]", $reply->id));
    }
}
