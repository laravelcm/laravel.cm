<?php

namespace App\Console\Commands\Cleanup;

use App\Models\User;
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

        $count = User::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(10))
            ->delete();

        $this->comment("Deleted {$count} unverified users.");

        $this->info('All done!');
    }
}
