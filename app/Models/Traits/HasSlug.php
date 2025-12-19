<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function findBySlug(string $slug): static
    {
        return static::query()->where('slug', $slug)->firstOrFail();
    }

    protected function slug(): Attribute
    {
        return Attribute::set(fn (string $value): string => $this->generateUniqueSlug($value));
    }

    private function generateUniqueSlug(string $value): string
    {
        $slug = Str::slug($value) ?: Str::random(5);
        $originalSlug = Str::slug($value) ?: Str::random(5);
        $counter = 0;

        while ($this->slugExists($slug, $this->exists ? $this->id : null)) {
            $counter++;
            $slug = $originalSlug.'-'.$counter;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = static::query()->where('slug', $slug);

        if (filled($ignoreId)) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
