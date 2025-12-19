<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TransactionStatus;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $id
 * @property-read TransactionStatus $status
 * @property-read array<string, mixed>|null $metadata
 */
final class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    use HasUuids;

    public $guarded = [];

    /**
     * @return string|array<string, mixed>
     */
    public function getMetadata(string $key, string $default = ''): string|array
    {
        if ($this->metadata && array_key_exists($key, $this->metadata)) {
            return $this->metadata[$key];
        }

        return $default;
    }

    /**
     * @param  array<string, mixed>  $revisions
     */
    public function setMetadata(array $revisions, bool $save = true): self
    {
        $this->fill([
            'metadata' => array_unique(array_merge($this->metadata ?? [], $revisions)),
        ]);

        if ($save) {
            $this->save();
        }

        return $this;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'status' => TransactionStatus::class,
        ];
    }

    /**
     * @param  Builder<Transaction>  $query
     */
    #[Scope]
    protected function complete(Builder $query): void
    {
        $query->where('status', TransactionStatus::COMPLETE);
    }
}
