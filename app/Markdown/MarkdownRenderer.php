<?php

declare(strict_types=1);

namespace App\Markdown;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Cache;
use LinkFinder;

final class MarkdownRenderer
{
    private const string CACHE_PREFIX = 'md:render:';

    private const int CACHE_TTL_SECONDS = 86_400 * 7;

    public function __construct(private readonly MarkdownSanitizer $sanitizer) {}

    public function render(string $markdown): string
    {
        if (mb_trim($markdown) === '') {
            return '';
        }

        $key = self::CACHE_PREFIX.hash('sha256', $markdown);

        return Cache::remember(
            key: $key,
            ttl: self::CACHE_TTL_SECONDS,
            callback: fn (): string => $this->renderWithoutCache($markdown),
        );
    }

    public function renderWithoutCache(string $markdown): string
    {
        $html = (string) Markdown::convert($markdown);
        $html = $this->sanitizer->purify($html);
        $html = MarkdownHelper::parseLiquidTags($html);

        return (new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ]))->processHtml($html);
    }

    public function forget(string $markdown): void
    {
        Cache::forget(self::CACHE_PREFIX.hash('sha256', $markdown));
    }
}
