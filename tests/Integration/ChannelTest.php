<?php

declare(strict_types=1);

use App\Exceptions\CannotAddChannelToChild;
use App\Models\Channel;

test('channel can have childs', function (): void {
    $channel = Channel::factory()->create();
    Channel::factory()->count(2)->create(['parent_id' => $channel->id]);

    expect($channel->items->count())->toEqual(2);
});

test('child channel can be a parent', function (): void {
    $channel = Channel::factory()->create();
    $child = Channel::factory()->create(['parent_id' => $channel->id]);

    Channel::factory()->create(['parent_id' => $child->id]);
})->throws(CannotAddChannelToChild::class);
