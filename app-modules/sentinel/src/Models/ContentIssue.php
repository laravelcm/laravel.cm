<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravelcm\Sentinel\Database\Factories\ContentIssueFactory;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;

/**
 * @property-read int $id
 * @property-read int $issueable_id
 * @property-read string $issueable_type
 * @property-read IssueType $type
 * @property-read IssueStatus $status
 * @property-read array<string, string>|null $details
 * @property-read CarbonInterface $detected_at
 * @property-read CarbonInterface|null $notified_at
 * @property-read CarbonInterface|null $resolved_at
 * @property-read CarbonInterface|null $deadline_at
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 * @property-read Model $issueable
 */
#[Fillable([
    'issueable_id',
    'issueable_type',
    'type',
    'status',
    'details',
    'detected_at',
    'notified_at',
    'resolved_at',
    'deadline_at',
])]
final class ContentIssue extends Model
{
    use HasFactory;

    public function issueable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isExpired(): bool
    {
        return $this->deadline_at?->isPast() ?? false;
    }

    protected static function newFactory(): Factory
    {
        return ContentIssueFactory::new();
    }

    protected function casts(): array
    {
        return [
            'type' => IssueType::class,
            'status' => IssueStatus::class,
            'details' => 'array',
            'detected_at' => 'datetime',
            'notified_at' => 'datetime',
            'resolved_at' => 'datetime',
            'deadline_at' => 'datetime',
        ];
    }
}
