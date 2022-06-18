<?php

namespace App\Console\Commands\Cleanup;

use App\Models\User;
use App\Notifications\SendEMailToDeletedUser;
use Illuminate\Console\Command;

class DeleteOldUnverifiedUsers extends Command
{
    protected $signature = 'lcm:delete-old-unverified-users';

    protected $description = 'Removed all unverified users.';

    public function handle()
    {
        $this->info('Deleting old unverified users...');

        $query = User::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(10));

        if ($query->get()->isNotEmpty()) {
            foreach ($query->get() as $user) {
                $user->notify((new SendEMailToDeletedUser())->delay(now()->addMinutes(5)));
            }
        }

        $count = $query->delete();

        $this->comment("Deleted {$count} unverified users.");

        $this->info('All done!');
    }
}
