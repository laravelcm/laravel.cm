<?php

declare(strict_types=1);

namespace App\Services;

final class ReleaseBodyRenderer
{
    public function __construct(private readonly string $repositoryUrl) {}

    public function render(string $markdown): string
    {
        $html = (string) md_to_html($markdown);

        $html = $this->stripUnsafeSchemes($html);
        $html = $this->enrichExternalLinks($html);

        return $this->linkifyPullRequestReferences($html);
    }

    private function stripUnsafeSchemes(string $html): string
    {
        return (string) preg_replace(
            '/href=(["\'])\s*(?:javascript|data|vbscript):[^"\']*\1/i',
            'href=$1#$1',
            $html,
        );
    }

    private function enrichExternalLinks(string $html): string
    {
        return (string) preg_replace_callback(
            '/<a\s+([^>]*?)>/i',
            static function (array $match): string {
                $attributes = $match[1];

                if (preg_match('/href=(["\'])(https?:\/\/[^"\']+)\1/i', $attributes) !== 1) {
                    return $match[0];
                }

                if (preg_match('/\btarget=/i', $attributes) === 1 || preg_match('/\brel=/i', $attributes) === 1) {
                    return $match[0];
                }

                return '<a '.mb_rtrim($attributes).' target="_blank" rel="noopener noreferrer nofollow">';
            },
            $html,
        );
    }

    private function linkifyPullRequestReferences(string $html): string
    {
        return (string) preg_replace(
            '/(?<![\w\/])#(\d+)\b/',
            '<a href="'.$this->repositoryUrl.'/pull/$1" target="_blank" rel="noopener noreferrer nofollow">#$1</a>',
            $html,
        );
    }
}
