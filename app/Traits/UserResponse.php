<?php

declare(strict_types=1);

namespace App\Traits;

use App\Http\Resources\AuthenticateUserResource;
use App\Http\Resources\EnterpriseResource;
use App\Models\User;

trait UserResponse
{
    /**
     * @param User $user
     * @return array{
     *      user: AuthenticateUserResource,
     *      token: string,
     *      roles: \Illuminate\Support\Collection,
     *      permissions: \Illuminate\Support\Collection,
     *     enterprise: EnterpriseResource|null
     *   }
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
