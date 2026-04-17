<?php

declare(strict_types=1);

use App\Livewire\Components\Spotlight;
use App\Spotlight\Commands\GoToChangelog;
use Livewire\Livewire;

describe(GoToChangelog::class, function (): void {
    it('exposes the translated name', function (): void {
        $command = new GoToChangelog;

        expect($command->getName())->toBe(__('global.navigation.changelog'));
    });

    it('navigates to the changelog route when executed via spotlight', function (): void {
        Livewire::test(Spotlight::class)
            ->call('executeCommand', (new GoToChangelog)->getId())
            ->assertRedirect(route('changelog'));
    });
});
