<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class CheckIfBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        // @phpstan-ignore-next-line
        if (Auth::check() && Auth::user()->banned_at) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => __('user.ban.message'),
            ]);
        }

        return $next($request);
    }
}
