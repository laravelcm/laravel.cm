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
        if (Auth::check() && Auth::user()->banned_at) {
            Auth::logout();
            
            return redirect()->route('login')->withErrors([
                'email' => __('Votre compte a été banni. Contactez l\'administrateur pour plus d\'informations.'),
            ]);
        }
        
        return $next($request);
    }
}