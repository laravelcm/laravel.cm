<?php

declare(strict_types=1);

namespace App\Traits;

trait FormatSocialAccount
{
    public function formatTwitterHandle(?string $userSocial): ?string
    {
        if (! $userSocial) {
            return null;
        }

        $handle = trim($userSocial);

        if (str_contains($handle, 'https://x.com/')) {
            return substr($handle, strlen('https://x.com/'));
        }

        if (str_contains($handle, 'https://twitter.com/')) {
            return substr($handle, strlen('https://twitter.com/'));
        }

        if (str_contains($handle, '@')) {
            return substr($handle, strlen('@'));
        }

        return $handle;
    }

    public function formatGithubHandle(?string $userSocial): ?string
    {
        if (! $userSocial) {
            return null;
        }

        $handle = trim($userSocial);
        $domain = 'https://github.com/';

        if (str_contains($handle, $domain)) {
            return substr($handle, strlen($domain));
        }

        return $handle;
    }

    public function formatLinkedinHandle(?string $userSocial): ?string
    {
        if (! $userSocial) {
            return null;
        }

        $handle = trim($userSocial);
        $domain = 'https://www.linkedin.com/in/';

        if (str_contains($handle, $domain)) {
            return substr($handle, strlen($domain));
        }

        return $handle;
    }
}
