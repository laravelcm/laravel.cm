<?php

declare(strict_types=1);

use App\Markdown\MarkdownRenderer;
use App\Models\Discussion;
use App\Models\Thread;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use League\CommonMark\Output\RenderedContentInterface;

if (! function_exists('active')) {
    /**
     * @param  array<string>  $routes
     */
    function active(array $routes, string $activeClass = 'active', string $defaultClass = '', bool $condition = true): string
    {
        return call_user_func_array([resolve(Illuminate\Routing\Router::class), 'is'], $routes) && $condition ? $activeClass : $defaultClass;
    }
}

if (! function_exists('is_active')) {
    /**
     * Determines if the given routes are active.
     */
    function is_active(string ...$routes): bool
    {
        return (bool) call_user_func_array([resolve(Illuminate\Routing\Router::class), 'is'], $routes);
    }
}

if (! function_exists('md_to_html')) {
    function md_to_html(string $markdown): RenderedContentInterface
    {
        return Markdown::convert($markdown);
    }
}

if (! function_exists('md_render')) {
    function md_render(string $markdown): string
    {
        return resolve(MarkdownRenderer::class)->render($markdown);
    }
}

if (! function_exists('md_to_text')) {
    function md_to_text(string $markdown): string
    {
        $text = preg_replace('/```[\s\S]*?```/', ' ', $markdown);
        $text = preg_replace('/`[^`\n]+`/', ' ', (string) $text);
        $text = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', (string) $text);
        $text = preg_replace('/#{1,6}\s+/', '', (string) $text);
        $text = preg_replace('/[*_]{1,2}([^*_\n]+)[*_]{1,2}/', '$1', (string) $text);
        $text = preg_replace('/!\[[^\]]*\]\([^\)]+\)/', '', (string) $text);

        return strip_tags(mb_trim((string) $text));
    }
}

if (! function_exists('replace_links')) {
    function replace_links(string $markdown): string
    {
        return new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ])->processHtml($markdown);
    }
}

if (! function_exists('get_current_theme')) {
    function get_current_theme(): string
    {
        return Auth::user() ? Auth::user()->setting('theme', 'light') : 'light';
    }
}

if (! function_exists('canonical')) {
    /**
     * @param  array<string>  $params
     */
    function canonical(string $route, array $params = []): string
    {
        $page = resolve('request')->get('page');
        $params = array_merge($params, ['page' => $page !== 1 ? $page : null]);

        ksort($params);

        return route($route, $params);
    }
}

if (! function_exists('getFilter')) {
    /**
     * @param  array<string>  $filters
     */
    function getFilter(string $key, array $filters = [], string $default = 'recent'): string
    {
        $filter = (string) request($key);

        return in_array($filter, $filters) ? $filter : $default;
    }
}

if (! function_exists('route_to_reply_able')) {
    /**
     * Returns the route for the replyAble.
     *
     * @param  Thread|Discussion  $replyAble
     */
    function route_to_reply_able(mixed $replyAble): string
    {
        $routeName = $replyAble instanceof Thread ? 'forum.show' : 'discussions.show';

        return route($routeName, $replyAble->slug);
    }
}

if (! function_exists('isHolidayWeek')) {
    function isHolidayWeek(): bool
    {
        $now = Date::now();

        $holidayStart = Date::createFromDate($now->year, 12, 21)->startOfDay();
        $holidayEnd = Date::createFromDate($now->year + 1, 1, 2)->endOfDay();

        return $now->between($holidayStart, $holidayEnd);
    }
}

if (! function_exists('safe_previous_url')) {
    function safe_previous_url(?string $fallback = null): string
    {
        $previous = url()->previous();
        $fallback ??= route('home');

        $appUrl = config('app.url');

        if (! is_string($appUrl)) {
            return $fallback;
        }

        $previousHost = parse_url($previous, PHP_URL_HOST);
        $expectedHost = parse_url($appUrl, PHP_URL_HOST);

        if (! is_string($previousHost) || ! is_string($expectedHost)) {
            return $fallback;
        }

        return $previousHost === $expectedHost ? $previous : $fallback;
    }
}
