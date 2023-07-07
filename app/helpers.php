<?php

declare(strict_types=1);

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Output\RenderedContentInterface;

if ( ! function_exists('active')) {
    /**
     * @param array<string> $routes
     * @param string $activeClass
     * @param string $defaultClass
     * @param bool $condition
     * @return string
     */
    function active(array $routes, string $activeClass = 'active', string $defaultClass = '', bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], $routes) && $condition ? $activeClass : $defaultClass;
    }
}

if ( ! function_exists('is_active')) {
    /**
     * Determines if the given routes are active.
     */
    function is_active(string ...$routes): bool
    {
        return (bool) call_user_func_array([app('router'), 'is'], (array) $routes);
    }
}

if ( ! function_exists('md_to_html')) {
    function md_to_html(string $markdown): RenderedContentInterface
    {
        return Markdown::convert($markdown);
    }
}

if ( ! function_exists('replace_links')) {
    function replace_links(string $markdown): string
    {
        return (new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ]))->processHtml($markdown);
    }
}

if ( ! function_exists('get_current_theme')) {
    function get_current_theme(): string
    {
        return Auth::user() ?
            Auth::user()->setting('theme', 'theme-light') :
            'theme-light';
    }
}

if ( ! function_exists('canonical')) {
    /**
     * @param string $route
     * @param array<string> $params
     * @return string
     */
    function canonical(string $route, array $params = []): string
    {
        $page = app('request')->get('page');
        $params = array_merge($params, ['page' => 1 !== $page ? $page : null]);

        ksort($params);

        return route($route, $params);
    }
}

if ( ! function_exists('getFilter')) {
    /**
     * @param string $key
     * @param array<string> $filters
     * @param string $default
     * @return string
     */
    function getFilter(string $key, array $filters = [], string $default = 'recent'): string
    {
        $filter = (string) request($key);

        return in_array($filter, $filters) ? $filter : $default;
    }
}

if ( ! function_exists('route_to_reply_able')) {
    /**
     * Returns the route for the replyAble.
     *
     * @param  \App\Models\Thread|\App\Models\Discussion  $replyAble
     * @return string
     */
    function route_to_reply_able(mixed $replyAble): string
    {
        return $replyAble instanceof \App\Models\Thread ?
            route('forum.show', $replyAble->slug()) :
            route('discussions.show', $replyAble->slug());
    }
}
