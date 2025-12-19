<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PremiumUserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class PremiumController extends Controller
{
    public function users(): JsonResponse
    {
        $users = Cache::remember(
            key: 'premium_users',
            ttl: now()->addMonth(),
            callback: fn () => User::query()
                ->select('name', 'username')
                ->limit(48)
                ->get()
        );

        $premium = collect();

        foreach ($users->chunk(16) as $key => $usersRow) {
            $usersArray[$key] = [];
            foreach ($usersRow as $user) {
                $usersArray[$key][] = new PremiumUserResource($user);
            }

            $premium->push($usersArray[$key]);
        }

        return response()->json($premium);
    }
}
