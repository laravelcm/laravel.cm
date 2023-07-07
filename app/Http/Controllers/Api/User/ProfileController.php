<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthenticateUserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class ProfileController extends Controller
{
    public function me(): JsonResponse
    {
        return response()->json(['user' => new AuthenticateUserResource(request()->user())]);
    }

    public function roles(): JsonResponse
    {
        /** @var User $user */
        $user = request()->user()->load(['roles', 'permissions']); // @phpstan-ignore-line

        return response()->json([
            'roles' => $user->roles()->pluck('name'),
            'permissions' => $user->permissions()->pluck('name'),
        ]);
    }
}
