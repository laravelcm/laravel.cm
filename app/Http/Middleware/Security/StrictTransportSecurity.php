<?php

declare(strict_types=1);

namespace App\Http\Middleware\Security;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class StrictTransportSecurity
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        $response->headers->add([
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
        ]);

        return $response;
    }
}
