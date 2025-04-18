<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property-read int $point
 * @property-read User payee
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
final class Reputation extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(config('gamify.payee_model'), 'payee_id');
    }

    /**
     * Get the owning subject model
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Undo last point
     *
     * @throws \Exception
     */
    public function undo(): void
    {
        if ($this->exists) {
            $this->payee->reducePoint($this->point);
            $this->delete();
        }
    }
}
