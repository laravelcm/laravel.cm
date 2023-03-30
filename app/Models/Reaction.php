<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReaction
 */
class Reaction extends Model
{
    use HasFactory;

    /**
     * @var string[]|bool
     */
    protected $guarded = [];

    public static function createFromName(string $name): self
    {
        return self::create(['name' => $name]);
    }

    /**
     * @return mixed
     */
    public function getResponder(): mixed
    {
        if ($this->getOriginal('pivot_responder_type', null)) {
            // @phpstan-ignore-next-line
            return forward_static_call(
                [$this->getOriginal('pivot_responder_type'), 'find'],
                $this->getOriginal('pivot_responder_id')
            );
        }

        return null;
    }
}
