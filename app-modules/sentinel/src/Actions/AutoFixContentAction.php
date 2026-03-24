<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Actions;

use Laravelcm\Sentinel\Contracts\Scannable;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;

final class AutoFixContentAction
{
    public function execute(ContentIssue $issue): bool
    {
        $model = $issue->issueable;

        if (! $model instanceof Scannable) {
            return false;
        }

        $column = $model->sentinelContentColumn();
        $content = $model->sentinelContent();
        $match = $issue->details['match'] ?? '';

        if ($match === '') {
            return false;
        }

        $cleaned = match ($issue->type) {
            IssueType::FailedUpload => $this->removeMatch($content, $match),
            IssueType::MissingHttps => $this->fixMissingHttps($content, $match),
            default => null,
        };

        if ($cleaned === null || $cleaned === $content) {
            return false;
        }

        $model->updateQuietly([$column => $cleaned]);

        $issue->update([
            'status' => IssueStatus::AutoFixed,
            'resolved_at' => now(),
        ]);

        return true;
    }

    private function removeMatch(string $content, string $match): string
    {
        return (string) preg_replace(
            '/'.preg_quote($match, '/').'\s*/',
            '',
            $content,
        );
    }

    private function fixMissingHttps(string $content, string $match): string
    {
        $fixed = (string) preg_replace('/\]\((?!https?:\/\/)/', '](https://', $match);

        return str_replace($match, $fixed, $content);
    }
}
