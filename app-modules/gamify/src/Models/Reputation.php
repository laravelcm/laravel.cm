<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Models;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravelcm\Gamify\Database\Factories\ReputationFactory;

/**
 * @property-read int $id
 * @property-read int $point
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read ?User $payee
 */
final class Reputation extends Model
{
    /** @use HasFactory<ReputationFactory> */
    use HasFactory;

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
