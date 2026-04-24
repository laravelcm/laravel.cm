<?php

declare(strict_types=1);

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ContentSecurityPolicy
{
    /**
     * @var array<int, string>
     */
    private const array DIRECTIVES = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://analytics.universy.app https://media.bitterbrains.com https://cdn.jsdelivr.net",
        "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com",
        "font-src 'self' data: https://fonts.bunny.net https://fonts.gstatic.com",
        "img-src 'self' data: blob: https://laravelcm.s3.fr-par.scw.cloud https://avatars.githubusercontent.com https://lh3.googleusercontent.com https://secure.gravatar.com https://www.google-analytics.com https://www.googletagmanager.com https://cdn.devdojo.com",
        "media-src 'self' https://laravelcm.s3.fr-par.scw.cloud",
        "connect-src 'self' https://analytics.universy.app https://www.google-analytics.com wss:",
        "frame-src 'self' https://www.youtube.com https://player.vimeo.com https://codepen.io https://codesandbox.io https://giphy.com https://*.giphy.com",
        "worker-src 'self' blob:",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'none'",
        'upgrade-insecure-requests',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('Content-Security-Policy', implode('; ', self::DIRECTIVES));
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
