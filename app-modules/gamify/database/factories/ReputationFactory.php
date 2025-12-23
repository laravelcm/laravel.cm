<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laravelcm\Gamify\Models\Reputation;

/**
 * @extends Factory<Reputation>
 */
final class ReputationFactory extends Factory
{
    protected $model = Reputation::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
