<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class TrackLastActivity
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
