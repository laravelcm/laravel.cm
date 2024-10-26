<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUsername
{
    public function username(): string
    {
        return $this->username;
    }

    public function setUsernameAttribute(string $username): void
    {
        $this->attributes['username'] = $this->generateUniqueUsername($username);
    }

    public static function findByUsername(string $username): self
    {
        return static::where('username', $username)->firstOrFail();
    }

    private function generateUniqueUsername(string $value): string
    {
        $username = $originalUsername = $value ?: Str::random(6);
        $counter = 0;

        while ($this->usernameExists($username, $this->exists ? $this->id : null)) {
            $counter++;
            $username = $originalUsername.$counter;
        }

        return $username;
    }

    private function usernameExists(string $username, int $ignoreId = null): bool
    {
        $query = $this->where('username', $username);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
