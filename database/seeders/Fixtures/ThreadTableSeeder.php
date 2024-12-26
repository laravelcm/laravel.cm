<?php

declare(strict_types=1);

namespace Database\Seeders\Fixtures;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class ThreadTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersIds = User::query()->inRandomOrder()
            ->limit(20)
            ->get()
            ->modelKeys();

        Thread::factory(['user_id' => array_rand($usersIds)])
            ->count(40)
            ->has(
                Reply::factory(['user_id' => array_rand($usersIds)])->count(5),
                'replies'
            )
            ->create();
    }
}
