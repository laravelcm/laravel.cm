<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravelcm\Sentinel\Enums\IssueStatus;
use Laravelcm\Sentinel\Enums\IssueType;
use Laravelcm\Sentinel\Models\ContentIssue;

/** @extends Factory<ContentIssue> */
final class ContentIssueFactory extends Factory
{
    protected $model = ContentIssue::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'issueable_id' => Article::factory()->approved(),
            'issueable_type' => (new Article)->getMorphClass(),
            'type' => fake()->randomElement(IssueType::cases()),
            'status' => IssueStatus::Detected,
            'details' => ['match' => '[test](example.com)'],
            'detected_at' => now(),
        ];
    }

    public function notified(int $deadlineDays = 30): static
    {
        return $this->state([
            'status' => IssueStatus::Notified,
            'notified_at' => now(),
            'deadline_at' => now()->addDays($deadlineDays),
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'status' => IssueStatus::Notified,
            'notified_at' => now()->subDays(31),
            'deadline_at' => now()->subDay(),
        ]);
    }
}
