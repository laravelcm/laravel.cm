<?php

declare(strict_types=1);

use App\Models\Discussion;
use App\Models\Thread;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Auth;
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

if (! function_exists('replace_links')) {
    function replace_links(string $markdown): string
    {
        return (new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ]))->processHtml($markdown);
    }
}

if (! function_exists('get_current_theme')) {
    function get_current_theme(): string
    {
        return Auth::user() ?
            Auth::user()->setting('theme', 'light') :
            'light';
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
        $now = Illuminate\Support\Facades\Date::now();

        $holidayStart = Illuminate\Support\Facades\Date::createFromDate($now->year, 12, 21)->startOfDay();
        $holidayEnd = Illuminate\Support\Facades\Date::createFromDate($now->year + 1, 1, 2)->endOfDay();

        return $now->between($holidayStart, $holidayEnd);
    }
}
