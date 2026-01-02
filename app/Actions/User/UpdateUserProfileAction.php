<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\EmailAddressWasChanged;
use App\Models\User;

final class UpdateUserProfileAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data, User $user, string $currentUserEmail): User
    {
        $user->update($data);

        if ($user->email !== $currentUserEmail) {
            $user->update(['email_verified_at' => null]);

            event(new EmailAddressWasChanged($user));
        }

        return $user;
    }
}
