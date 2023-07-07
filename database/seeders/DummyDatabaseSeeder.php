<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Seeders\Fixtures\ArticleTableSeeder;
use Database\Seeders\Fixtures\DiscussionTableSeeder;
use Database\Seeders\Fixtures\ThreadTableSeeder;
use Database\Seeders\Fixtures\UsersTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DummyDatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ArticleTableSeeder::class,
            DiscussionTableSeeder::class,
            ThreadTableSeeder::class,
        ]);
    }
}
