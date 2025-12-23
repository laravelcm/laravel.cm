<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasUsername
{
    public static function findByUsername(string $username): self
    {
        return static::query()->where('username', $username)->firstOrFail();
    }

    protected function username(): Attribute
    {
        return Attribute::set(fn (string $value): string => $this->generateUniqueUsername($value));
    }

    private function generateUniqueUsername(string $value): string
    {
        $username = $value;
        $originalUsername = $value;
        $counter = 0;

        while ($this->usernameExists($username, $this->exists ? $this->id : null)) {
            $counter++;
            $username = $originalUsername.$counter;
        }

        return $username;
    }

    private function usernameExists(string $username, ?int $ignoreId = null): bool
    {
        $query = $this->where('username', $username);

        if (filled($ignoreId)) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
