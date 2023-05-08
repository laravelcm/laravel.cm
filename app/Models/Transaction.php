<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperTransaction
 */
class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    public $guarded = [];

    public $casts = [
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMetadata(string $name, string $default = ''): string | array
    {
        if ($this->metadata && array_key_exists($name, $this->metadata)) {
            return $this->metadata[$name];
        }

        return $default;
    }

    public function setMetadata(array $revisions, bool $save = true): self
    {
        $this->metadata = array_merge($this->metadata ?? [], $revisions);

        if ($save) {
            $this->save();
        }

        return $this;
    }
}
