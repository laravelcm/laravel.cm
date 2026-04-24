<?php

declare(strict_types=1);

namespace App\Traits;

use App\Http\Resources\AuthenticateUserResource;
use App\Http\Resources\EnterpriseResource;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * @phpstan-ignore trait.unused
 */
trait UserResponse
{
    /**
     * @return array{user: AuthenticateUserResource, token: string, roles: Collection, permissions: Collection, enterprise: EnterpriseResource|null}
     */
    public function userMetaData(User $user): array
    {
        return [
            'user' => new AuthenticateUserResource($user),
            'token' => $user->createToken(
                name: 'api-session',
                abilities: ['*'],
                expiresAt: Date::now()->addDays(30),
            )->plainTextToken,
            'roles' => $user->roles()->pluck('name'),
            'permissions' => $user->permissions()->pluck('name'),
            'enterprise' => $user->enterprise ? new EnterpriseResource($user->enterprise) : null,
        ];
    }
}
