<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Reaction extends Model
{
    protected $guarded = [];

    public static function createFromName(string $name): self
    {
        return self::query()->create(['name' => $name]);
    }

    public function getResponder(): mixed
    {
        if ($this->getOriginal('pivot_responder_type', null)) {
            return forward_static_call(
                [$this->getOriginal('pivot_responder_type'), 'find'], // @phpstan-ignore-line
                $this->getOriginal('pivot_responder_id')
            );
        }

        return null;
    }
}
