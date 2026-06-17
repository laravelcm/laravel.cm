<?php

declare(strict_types=1);

namespace App\Console\Commands\Cleanup;

use App\Models\User;
use App\Notifications\SendEMailToDeletedUser;
use Illuminate\Console\Command;

#[\Illuminate\Console\Attributes\Description('Removed all unverified users.')]
#[\Illuminate\Console\Attributes\Signature('lcm:delete-old-unverified-users')]
final class DeleteOldUnverifiedUsers extends Command
{
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

        $this->comment(sprintf('Deleted %d unverified users.', $count));

        $this->info('All done!');
    }
}
