<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AssignUserRole extends Command
{
    protected $signature = 'lcm:assign-user-role';

    protected $description = 'Assign user role to all users without any role.';

    public function handle(): void
    {
        $this->info('Assigning user role to all users...');

        foreach (User::withoutRole()->get() as $user) {
            $user->assignRole('user');
        }

        $this->info('All done!');
    }
}
