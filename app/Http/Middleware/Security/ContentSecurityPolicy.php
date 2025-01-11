<?php

declare(strict_types=1);

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        $response->headers->add([
            'Content-Security-Policy' => "default-src 'self'; script-src 'unsafe-inline'; style-src 'unsafe-inline'; img-src *;",
        ]);

        return $response;
    }
}
