<?php

declare(strict_types=1);

use App\Livewire\Components\Spotlight;
use App\Models\User;
use App\Spotlight\Commands\ToggleLocale;
use Livewire\Livewire;

describe(ToggleLocale::class, function (): void {
    it('stores the new locale in session for guests', function (): void {
        app()->setLocale('fr');

        Livewire::test(Spotlight::class)
            ->call('executeCommand', (new ToggleLocale)->getId());

        expect(session('locale'))->toBe('en');
    });

    it('persists the new locale in user settings when authenticated', function (): void {
        $user = User::factory()->create(['settings' => ['locale' => 'fr']]);
        $this->actingAs($user);
        app()->setLocale('fr');

        Livewire::test(Spotlight::class)
            ->call('executeCommand', (new ToggleLocale)->getId());

        expect($user->fresh()->setting('locale'))->toBe('en')
            ->and(session('locale'))->toBe('en');
    });

    it('toggles back from en to fr', function (): void {
        app()->setLocale('en');

        Livewire::test(Spotlight::class)
            ->call('executeCommand', (new ToggleLocale)->getId());

        expect(session('locale'))->toBe('fr');
    });
});
