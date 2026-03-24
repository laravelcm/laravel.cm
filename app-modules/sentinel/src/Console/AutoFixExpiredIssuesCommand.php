<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Console;

use Illuminate\Console\Command;
use Laravelcm\Sentinel\Actions\AutoFixContentAction;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Models\ContentIssue;

final class AutoFixExpiredIssuesCommand extends Command
{
    protected $signature = 'sentinel:auto-fix';

    protected $description = 'Auto-fix content issues past their deadline';

    public function handle(AutoFixContentAction $action): int
    {
        $issues = ContentIssue::query()
            ->where('status', IssueStatus::Notified)
            ->where('deadline_at', '<', now())
            ->with('issueable')
            ->get();

        if ($issues->isEmpty()) {
            $this->components->info('No expired issues to fix.');

            return self::SUCCESS;
        }

        $fixed = 0;

        foreach ($issues as $issue) {
            if ($action->execute($issue)) {
                $fixed++;
                $modelName = class_basename($issue->issueable_type);
                $this->line(sprintf('  [%s #%d] %s auto-fixed', $modelName, $issue->issueable_id, $issue->type->value));
            }
        }

        $this->components->info(sprintf('%d/%d issues auto-fixed.', $fixed, $issues->count()));

        return self::SUCCESS;
    }
}
