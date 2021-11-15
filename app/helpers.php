<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     */
    function active($routes, string $activeClass = 'active', string $defaultClass = '', bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? $activeClass : $defaultClass;
    }
}

if (! function_exists('is_active')) {
    /**
     * Determines if the given routes are active.
     */
    function is_active($routes): bool
    {
        return (bool) call_user_func_array([app('router'), 'is'], (array) $routes);
    }
}

if (! function_exists('md_to_html')) {
    /**
     * Convert Markdown to HTML.
     */
    function md_to_html(string $markdown): string
    {
        return Markdown::convertToHtml($markdown);
    }
}

if (! function_exists('replace_links')) {
    /**
     * Convert Standalone Urls to HTML.
     */
    function replace_links(string $markdown): string
    {
        return (new LinkFinder([
            'attrs' => ['target' => '_blank', 'rel' => 'nofollow'],
        ]))->processHtml($markdown);
    }
}

if (! function_exists('get_current_theme')) {
    /**
     * Get the current active theme from user settings.
     */
    function get_current_theme(): string
    {
        return Auth::user() ?
            Auth::user()->setting('theme', 'theme-light') :
            'theme-light';
    }
}

if (! function_exists('canonical')) {
    /**
     * Generate a canonical URL to the given route and allowed list of query params.
     */
    function canonical(string $route, array $params = []): string
    {
        $page = app('request')->get('page');
        $params = array_merge($params, ['page' => $page != 1 ? $page : null]);

        ksort($params);

        return route($route, $params);
    }
}

if (! function_exists('getFilter')) {
    function getFilter(string $key, array $filters = [], string $default = 'recent'): string
    {
        $filter = (string) request($key);

        return in_array($filter, $filters) ? $filter : $default;
    }
}
