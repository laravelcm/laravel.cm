<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Enterprise;
use App\Models\User;

trait HasSettings
{
    /**
     * Retrieve a setting with a given name or fall back to the default.
     */
    public function setting(string $name, string $default): string
    {
        if ($this->settings && array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }

        return $default;
    }

    /**
     * @param array<string> $revisions
     * @param bool $save
     */
    public function settings(array $revisions, bool $save = true): self
    {
        $this->settings = array_merge($this->settings ?? [], $revisions);

        if ($save) {
            $this->save();
        }

        return $this;
    }
}
