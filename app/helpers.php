<?php

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     */
    function active($routes, string $activeClass = 'active', bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? $activeClass : '';
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
        return app(App\Markdown\Converter::class)->toHtml($markdown);
    }
}
