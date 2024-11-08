<?php

declare(strict_types=1);

use App\Filament\Resources\ChannelResource;
use App\Filament\Resources\ChannelResource\Pages\CreateChannel;
use App\Filament\Resources\ChannelResource\Pages\ListChannels;
use App\Models\Channel;
use Filament\Actions\EditAction;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
    $this->channels = Channel::factory()
        ->count(10)
        ->create();
});

describe(ChannelResource::class, function (): void {

    it('page can display table with records', function (): void {
        Livewire::test(ListChannels::class)
            ->assertCanSeeTableRecords($this->channels);
    });

    it('Admin user can create channel', function (): void {
        $name = 'my channel';

        Livewire::test(CreateChannel::class)
            ->fillForm([
                'name' => $name,
                'color' => '#FFFFFF',
            ])
            ->call('create');
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
