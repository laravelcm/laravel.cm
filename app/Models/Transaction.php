<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $id
 * @property array<array-key, mixed>|null $metadata
 */
final class Transaction extends Model
{
    use HasUuids;

    public $guarded = [];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function getMetadata(string $key, string $default = ''): string|array
    {
        if ($this->metadata && array_key_exists($key, $this->metadata)) {
            return $this->metadata[$key];
        }

        return $default;
    }

    public function setMetadata(array $revisions, bool $save = true): self
    {
        $this->metadata = array_unique(array_merge($this->metadata ?? [], $revisions));

        if ($save) {
            $this->save();
        }

        return $this;
    }

    /**
     * @param  Builder<Transaction>  $query
     */
    #[Scope]
    protected function complete(Builder $query): void
    {
        $query->where('status', TransactionStatus::COMPLETE->value);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
