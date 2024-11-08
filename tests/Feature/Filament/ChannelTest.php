<?php

declare(strict_types=1);

use App\Filament\Resources\ChannelResource;
use App\Filament\Resources\ChannelResource\Pages\ListChannels;
use App\Models\Channel;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(ChannelResource::class, function (): void {
    it('page can display table with records', function (): void {
        $channels = Channel::factory()
            ->count(10)
            ->create();
        Livewire::test(ListChannels::class)
            ->assertCanSeeTableRecords($channels);
    });

    it('Admin user can create channel', function (): void {
        Livewire::test(ListChannels::class)
            ->callAction(CreateAction::class, data: [
                'name' => $name = 'my channel',
                'color' => '#FFFFFF',
            ])
            ->assertHasNoActionErrors()
            ->assertStatus(200);

        $channel = Channel::first();

        expect($channel)
            ->toBeInstanceOf(Channel::class)
            ->and($channel->name)->toBe($name);
    });

    it('Admin user can edit channel', function (): void {
        $channel = Channel::factory()->create();

        Livewire::test(ListChannels::class)
            ->callTableAction(EditAction::class, $channel, data: [
                'name' => 'Edited channel',
            ])
            ->assertHasNoTableActionErrors();

        $channel->refresh();

        expect($channel->name)
            ->toBe('Edited channel');
    });

})->group('channels');
