<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;
use App\Http\Resources\AuthenticateUserResource;
use App\Http\Resources\EnterpriseResource;
use App\Models\User;

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
            'token' => $user->createToken($user->email)->plainTextToken,
            'roles' => $user->roles()->pluck('name'),
            'permissions' => $user->permissions()->pluck('name'),
            'enterprise' => $user->enterprise ? new EnterpriseResource($user->enterprise) : null,
        ];
    }
}
