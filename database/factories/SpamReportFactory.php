<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SpamReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpamReport>
 */
final class SpamReportFactory extends Factory
{
    protected $model = SpamReport::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
