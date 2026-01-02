<?php

declare(strict_types=1);

namespace App\Traits;

trait HasSettings
{
    public function setting(string $key, ?string $default = null): mixed
    {
        if ($this->settings && array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
        }

        return $default;
    }

    /**
     * @param  array<string, mixed>  $revisions
     */
    public function settings(array $revisions): self
    {
        $this->update([
            'settings' => array_merge($this->settings ?? [], $revisions),
        ]);

        return $this;
    }
}
