<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Actions;

use Illuminate\Database\Eloquent\Model;
use Laravelcm\Sentinel\Contracts\Scannable;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;

final class ScanContentAction
{
    /** @return array<int, array{type: IssueType, details: array<string, string>}> */
    public function execute(Model&Scannable $model): array
    {
        $content = $model->sentinelContent();
        $issues = [];

        $issues = array_merge($issues, $this->detectMissingHttps($content));
        $issues = array_merge($issues, $this->detectFailedUploads($content));

        $this->syncIssues($model, $issues);

        return $issues;
    }

    /** @return array<int, array{type: IssueType, details: array<string, string>}> */
    private function detectMissingHttps(string $content): array
    {
        $issues = [];

        preg_match_all('/\[[^\]]*\]\((?!https?:\/\/|mailto:|\/|#)([^)]+)\)/', $content, $matches);

        foreach ($matches[0] as $match) {
            if (str_contains($match, 'Uploading...')) {
                continue;
            }

            $issues[] = [
                'type' => IssueType::MissingHttps,
                'details' => ['match' => $match],
            ];
        }

        return $issues;
    }

    /** @return array<int, array{type: IssueType, details: array<string, string>}> */
    private function detectFailedUploads(string $content): array
    {
        $issues = [];

        preg_match_all('/!?\[[^\]]*\]\(Uploading\.\.\.\)/', $content, $matches);

        foreach ($matches[0] as $match) {
            $issues[] = [
                'type' => IssueType::FailedUpload,
                'details' => ['match' => $match],
            ];
        }

        return $issues;
    }

    /** @param array<int, array{type: IssueType, details: array<string, string>}> $issues */
    private function syncIssues(Model&Scannable $model, array $issues): void
    {
        $existingIssues = $model->contentIssues()
            ->whereIn('status', [IssueStatus::Detected, IssueStatus::Notified])
            ->get();

        /** @var ContentIssue $existing */
        foreach ($existingIssues as $existing) {
            $stillExists = collect($issues)->contains(
                fn (array $issue): bool => $issue['type'] === $existing->type
                    && $issue['details']['match'] === ($existing->details['match'] ?? ''),
            );

            if (! $stillExists) {
                $existing->update([
                    'status' => IssueStatus::Resolved,
                    'resolved_at' => now(),
                ]);
            }
        }

        foreach ($issues as $issue) {
            $exists = $model->contentIssues()
                ->where('type', $issue['type'])
                ->whereIn('status', [IssueStatus::Detected, IssueStatus::Notified])
                ->whereJsonContains('details->match', $issue['details']['match'])
                ->exists();

            if (! $exists) {
                $model->contentIssues()->create([
                    'type' => $issue['type'],
                    'status' => IssueStatus::Detected,
                    'details' => $issue['details'],
                    'detected_at' => now(),
                ]);
            }
        }
    }
}
