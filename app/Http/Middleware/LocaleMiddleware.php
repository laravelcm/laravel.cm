<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $browserLocale = explode('_', (string) $request->getPreferredLanguage())[0];
        $currentLocale = app()->getLocale();
        $activeLocale = session()->get('locale');
        $supportedLocales = config('lcm.supported_locales');

        if (Auth::check()) {
            $userLocale = Auth::user()?->setting('locale', $currentLocale);

            if ($userLocale && $userLocale !== $currentLocale) {
                app()->setLocale($userLocale);
            }
        } else {
            if (! $activeLocale && in_array($browserLocale, $supportedLocales)) {
                app()->setLocale($browserLocale);
            } else {
                app()->setLocale($activeLocale);
            }
        }

        return $next($request);
    }
}
