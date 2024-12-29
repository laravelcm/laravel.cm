<?php

declare(strict_types=1);

namespace App\Console\Commands\Cleanup;

use App\Models\User;
use App\Notifications\SendEMailToDeletedUser;
use Illuminate\Console\Command;

final class DeleteOldUnverifiedUsers extends Command
{
    protected $signature = 'lcd:delete-old-unverified-users';

    protected $description = 'Removed all unverified users.';

    public function handle(): void
    {
        $this->info('Deleting old unverified users...');

        $query = User::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(10));

        $users = $query->get();

        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $user->notify((new SendEMailToDeletedUser)->delay(now()->addMinutes(5)));
            }
        }

        $count = $query->delete();

        $this->comment("Deleted {$count} unverified users.");

        $this->info('All done!');
    }
}
