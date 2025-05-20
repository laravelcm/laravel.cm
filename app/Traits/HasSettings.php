<?php

declare(strict_types=1);

namespace App\Traits;

trait HasSettings
{
    public function setting(string $key, string $default): mixed
    {
        if ($this->settings && array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
        }

        return $default;
    }

    public function settings(array $revisions, bool $save = true): self
    {
        $this->settings = array_merge($this->settings ?? [], $revisions);

        if ($save) {
            $this->save();
        }

        return $this;
    }
}
