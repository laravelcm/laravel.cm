<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Traits\FormatSocialAccount;
use Illuminate\Console\Command;

final class UpdateUserSocialAccount extends Command
{
    use FormatSocialAccount;

    protected $signature = 'lcm:update-user-social-account';

    protected $description = 'Update user social account to normal format';

    public function handle(): void
    {
        $this->info('Start updating users social account...');

        foreach (User::verifiedUsers()->get() as $user) {
            $this->info('Updating '.$user->username.'...');
            $user->twitter_profile = $this->formatTwitterHandle($user->twitter_profile);
            $user->github_profile = $this->formatGithubHandle($user->github_profile);
            $user->linkedin_profile = $this->formatLinkedinHandle($user->linkedin_profile);
            $user->save();
        }

        $this->info('All done!');
    }
}
