<?php

declare(strict_types=1);

namespace App\Traits;

trait FormatSocialAccount
{
    public function formatGithubHandle(?string $userSocial): ?string
    {
        if (blank($userSocial)) {
            return null;
        }

        $handle = $this->trimAndRemovePrefix($userSocial);

        if (str_contains($handle, 'github.com')) {
            return substr($handle, strpos($handle, 'github.com/') + 11);
        }

        return $handle;
    }

    public function formatLinkedinHandle(?string $userSocial): ?string
    {
        if (blank($userSocial)) {
            return null;
        }

        $handle = $this->trimAndRemovePrefix($userSocial);

        if (str_contains($handle, 'linkedin.com/in/')) {
            return substr($handle, strpos($handle, 'linkedin.com/in/') + 16);
        }

        return $handle;
    }

    public function formatTwitterHandle(?string $userSocial): ?string
    {
        if (blank($userSocial)) {
            return null;
        }
        if (str_starts_with(trim($userSocial), '@')) {
            return substr(trim($userSocial), 1);
        }

        $handle = $this->trimAndRemovePrefix($userSocial);

        if (str_contains($handle, 'twitter.com/') || str_contains($handle, 'x.com/')) {
            if (str_contains($handle, 'twitter.com/')) {
                return substr($handle, strpos($handle, 'twitter.com/') + 12);
            }

            return substr($handle, strpos($handle, 'x.com/') + 6);
        }

        return $handle;
    }

    private function trimAndRemovePrefix(string $url): string
    {
        $url = (string) preg_replace('~https?://~', '', $url);

        return trim((string) preg_replace('~www\.~', '', $url));
    }
}
