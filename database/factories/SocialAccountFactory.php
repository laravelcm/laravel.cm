<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SocialAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialAccount>
 */
final class SocialAccountFactory extends Factory
{
    protected $model = SocialAccount::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
