<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

#[\Illuminate\Console\Attributes\Description('Assign user role to all users without any role.')]
#[\Illuminate\Console\Attributes\Signature('lcm:assign-user-role')]
final class AssignUserRole extends Command
{
    public function handle(): void
    {
        $this->info('Assigning user role to all users...');

        foreach (User::query()->scopes('withoutRole')->get() as $user) {
            $user->assignRole('user');
        }

        $this->info('All done!');
    }
}
