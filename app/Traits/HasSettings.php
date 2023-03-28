<?php

declare(strict_types=1);

namespace App\Traits;

trait HasSettings
{
    /**
     * Retrieve a setting with a given name or fall back to the default.
     */
    public function setting(string $name, $default = null): string
    {
        if ($this->settings && array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }

        return $default;
    }

    /**
     * Update one or more settings and then optionally save the model.
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
