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
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    public static function createFromName($name): self
    {
        return self::create(['name' => $name]);
    }

    public function getResponder()
    {
        if ($this->getOriginal('pivot_responder_type', null)) {
            return forward_static_call(
                [$this->getOriginal('pivot_responder_type'), 'find'],
                $this->getOriginal('pivot_responder_id')
            );
        }

        return null;
    }
}
