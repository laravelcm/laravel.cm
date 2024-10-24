<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

final class TrackLastActiveAt
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = $request->user()) {
            $lastActive = $user->last_active_at;

            if (! $lastActive || $lastActive->diffInMinutes(Carbon::now()) >= 3) {
                $user->update([
                    'last_active_at' => now(),
                ]);
            }
        }
        return $next($request);
    }
}
