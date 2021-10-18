<?php

namespace App\Console\Commands\Cleanup;

use App\Models\User;
use App\Notifications\SendEMailToDeletedUser;
use Illuminate\Console\Command;

class DeleteOldUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lcm:delete-old-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removed all unverified users.';

    public function handle()
    {
        $this->info('Deleting old unverified users...');

        $query = User::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(10));

        if ($query->get()->isNotEmpty()) {
            foreach ($query->get() as $user) {
                $user->notify(new SendEMailToDeletedUser());
            }
        }

        $count = $query->delete();

        $this->comment("Deleted {$count} unverified users.");

        $this->info('All done!');
    }
}
