<?php

declare(strict_types=1);

namespace App\Markdown;

final class SuspiciousContentDetector
{
    /**
     * @var array<int, string> Host patterns blocklist (case-insensitive regex)
     */
    private const array BLOCKED_HOST_PATTERNS = [
        '/^(?:\d{1,3}\.){3}\d{1,3}$/',
        '/\.onion$/i',
        '/bit\.ly$/i',
        '/tinyurl\.com$/i',
        '/goo\.gl$/i',
        '/t\.co$/i',
        '/ow\.ly$/i',
        '/is\.gd$/i',
        '/buff\.ly$/i',
        '/rb\.gy$/i',
        '/rebrand\.ly$/i',
        '/shorturl\.at$/i',
        '/cutt\.ly$/i',
    ];

    /**
     * @var array<int, string> Suspicious keywords in URL paths
     */
    private const array SUSPICIOUS_PATH_KEYWORDS = [
        'login',
        'signin',
        'verify',
        'wallet',
        'metamask',
        'phantom',
        'airdrop',
        'free-crypto',
        'reset-password',
        'security-alert',
        'account-suspended',
    ];

    /**
     * @var array<int, string> File extensions never expected in legitimate content URLs
     */
    private const array BLOCKED_URL_EXTENSIONS = [
        'html', 'htm', 'xhtml', 'shtml',
        'exe', 'bat', 'cmd', 'msi', 'ps1', 'sh',
        'php', 'phtml', 'asp', 'aspx', 'jsp',
        'vbs', 'js', 'jar',
        'apk', 'dmg', 'pkg',
    ];

    private const int MAX_URL_COUNT = 10;

    /**
     * Analyse markdown content for suspicious patterns.
     *
     * @return array<int, string> Array of rejection reasons (empty if content is clean)
     */
    public function analyse(string $markdown): array
    {
        $reasons = [];

        $urls = $this->extractUrls($markdown);

        if (count($urls) > self::MAX_URL_COUNT) {
            $reasons[] = 'too_many_urls';
        }

        foreach ($urls as $url) {
            $host = parse_url($url, PHP_URL_HOST);
            $path = (string) parse_url($url, PHP_URL_PATH);
            if (! is_string($host)) {
                continue;
            }

            if ($host === '') {
                continue;
            }

            foreach (self::BLOCKED_HOST_PATTERNS as $pattern) {
                if (preg_match($pattern, $host) === 1) {
                    $reasons[] = 'blocked_host:'.$host;

                    break;
                }
            }

            foreach (self::SUSPICIOUS_PATH_KEYWORDS as $keyword) {
                if (mb_stripos($path, $keyword) !== false) {
                    $reasons[] = 'suspicious_path:'.$keyword;

                    break;
                }
            }

            if (preg_match('/\.([a-z0-9]{1,5})(?:$|\?)/i', $path, $matches) === 1) {
                $ext = mb_strtolower($matches[1]);
                if (in_array($ext, self::BLOCKED_URL_EXTENSIONS, true)) {
                    $reasons[] = 'blocked_extension:'.$ext;
                }
            }

            if ($this->looksLikeHomographAttack($host)) {
                $reasons[] = 'homograph_attack:'.$host;
            }
        }

        return array_values(array_unique($reasons));
    }

    public function isSuspicious(string $markdown): bool
    {
        return $this->analyse($markdown) !== [];
    }

    /**
     * @return array<int, string>
     */
    private function extractUrls(string $markdown): array
    {
        preg_match_all(
            '/https?:\/\/[^\s\)\]<>"\']+/i',
            $markdown,
            $matches,
        );

        return array_values(array_unique($matches[0]));
    }

    private function looksLikeHomographAttack(string $host): bool
    {
        if (preg_match('/[^\x00-\x7F]/', $host) === 1 && str_starts_with($host, 'xn--') === false) {
            return true;
        }

        $suspiciousLookalikes = [
            'paypa1', 'g00gle', 'amaz0n', 'rnicrosoft', 'faceb00k', 'app1e',
        ];

        foreach ($suspiciousLookalikes as $pattern) {
            if (mb_stripos($host, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }
}
