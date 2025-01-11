<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class CacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var \Illuminate\Http\Response $response
         */
        $response = $next($request);

        if (Auth::check()) {
            $response->setCache(
                options: [
                    'private' => true,
                    'max_age' => 0,
                    's_maxage' => 0,
                    'no_store' => true,
                ],
            );
        } else {
            $response->setCache(
                options: [
                    'public' => true,
                    'max_age' => 60,
                    's_maxage' => 60,
                ],
            );

            foreach ($response->headers->getCookies() as $cookie) {
                $response->headers->removeCookie(
                    name: $cookie->getName(),
                );
            }
        }

        return $response;
    }
}
