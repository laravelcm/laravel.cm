<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SpamReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read int $reportable_id
 * @property-read string $reportable_type
 * @property-read ?string $reason
 * @property-read ?User $user
 */
final class SpamReport extends Model
{
    /** @use HasFactory<SpamReportFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
