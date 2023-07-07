<?php

declare(strict_types=1);

namespace Database\Seeders\Fixtures;

use App\Models\Discussion;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DiscussionTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $usersIds = User::all()->modelKeys();
        $tagsIds = Tag::query()
            ->whereJsonContains('concerns', ['discussion'])
            ->get()
            ->modelKeys();
        $discussions = Discussion::factory()->count(20)->create([
            'user_id' => (int) array_rand($usersIds),
        ]);

        foreach ($discussions as $discussion) {
            /** @var $discussion Discussion */
            $discussion->syncTags(array_rand($tagsIds, 3));
        }
    }
}
