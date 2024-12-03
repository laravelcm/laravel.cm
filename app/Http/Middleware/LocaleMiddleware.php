<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

final class LocaleMiddleware
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $lang = config('lcm.lang.app_local');
        $supportLang = config('lcm.lang.support_local');
        if (! Auth::check()) {
            if (! is_null($request->server('HTTP_ACCEPT_LANGUAGE'))) {
                $navigatorLang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
                if (in_array($navigatorLang, $supportLang)) {
                    $lang = $navigatorLang;
                }
            }
        }
        if (! is_null($user)) {
            if (isset($user->settings['default_lang']) && $user->settings['default_lang'] != $lang) {
                $lang = $user->settings['default_lang'];
            }
        }
        app()->setLocale($lang);

        return $next($request);
    }
}
