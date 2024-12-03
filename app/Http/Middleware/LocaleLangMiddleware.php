<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

final class LocaleLangMiddleware
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! session()->has('locale')) {
            $navigatorLang = $request->server('HTTP_ACCEPT_LANGUAGE');
            $navigatorLang = (is_string($navigatorLang) && strlen($navigatorLang) >= 2) ? $navigatorLang : '';
            $navigatorLang = substr($navigatorLang, 0, 2);
            $lang = in_array($navigatorLang, ['fr', 'en']) ? $navigatorLang : 'fr';
            $request->session()->put('locale',  $lang);
        }
        app()->setLocale(session()->get('locale'));

        return $next($request);
    }
}
