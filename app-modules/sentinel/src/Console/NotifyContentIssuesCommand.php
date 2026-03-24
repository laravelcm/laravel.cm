<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Models\ContentIssue;
use Laravelcm\Sentinel\Notifications\ContentIssuesDetectedNotification;

final class NotifyContentIssuesCommand extends Command
{
    protected $signature = 'sentinel:notify';

    protected $description = 'Notify authors about detected content issues';

    public function handle(): int
    {
        /** @var int $deadlineDays */
        $deadlineDays = config('sentinel.deadline_days', 30);

        $issues = ContentIssue::query()
            ->where('status', IssueStatus::Detected)
            ->with('issueable.user')
            ->get();

        if ($issues->isEmpty()) {
            $this->components->info('No pending issues to notify.');

            return self::SUCCESS;
        }

        /** @var \Illuminate\Support\Collection<int, \Illuminate\Support\Collection<int, ContentIssue>> $grouped */
        $grouped = $issues->groupBy(
            fn (ContentIssue $issue): int => (int) $issue->issueable->user_id, // @phpstan-ignore property.notFound
        );

        $notified = 0;

        foreach ($grouped as $userIssues) {
            /** @var User|null $user */
            $user = $userIssues->first()?->issueable->user; // @phpstan-ignore property.notFound

            if (! $user) {
                continue;
            }

            $user->notify(new ContentIssuesDetectedNotification($userIssues, $deadlineDays));

            $userIssues->each(function (ContentIssue $issue) use ($deadlineDays): void {
                $issue->update([
                    'status' => IssueStatus::Notified,
                    'notified_at' => now(),
                    'deadline_at' => now()->addDays($deadlineDays),
                ]);
            });

            $notified++;
            $this->line(sprintf('  Notified %s (%d issues)', $user->name, $userIssues->count()));
        }

        $this->components->info($notified.' author(s) notified.');

        return self::SUCCESS;
    }
}
