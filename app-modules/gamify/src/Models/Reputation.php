<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property-read int $point
 * @property-read User|null $payee
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
final class Reputation extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(config('gamify.payee_model'), 'payee_id'); // @phpstan-ignore-line
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function undo(): void
    {
        if ($this->exists) {
            $this->payee?->reducePoint($this->point);
            $this->delete();
        }
    }
}
