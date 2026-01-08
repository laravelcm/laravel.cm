<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasPublicId
{
    public static function bootHasPublicId(): void
    {
        static::creating(function (self $model): void {
            $model->fill([
                'public_id' => $model->generatePublicId(),
            ]);
        });
    }

    /**
     * @param  array<array-key, string>  $columns
     */
    public static function findByPublicId(string $publicId, array $columns = ['*']): ?static
    {
        return static::query()->select($columns)
            ->where('public_id', $publicId)
            ->first();
    }

    public function generatePublicId(): string
    {
        return (string) Str::orderedUuid();
    }

    /**
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    #[Scope]
    protected function wherePublicId(Builder $query, string $publicId): Builder
    {
        return $query->where('public_id', $publicId);
    }
}
