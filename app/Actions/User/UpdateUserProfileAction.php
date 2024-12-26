<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Events\EmailAddressWasChanged;
use App\Models\User;

final class UpdateUserProfileAction
{
    public function execute(array $data, User $user, string $currentUserEmail): User
    {
        $user->update($data);

        if ($user->email !== $currentUserEmail) {
            $user->email_verified_at = null;
            $user->save();

            event(new EmailAddressWasChanged($user));
        }

        return $user;
    }
}
