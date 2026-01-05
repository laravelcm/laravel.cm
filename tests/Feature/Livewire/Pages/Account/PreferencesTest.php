<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Preferences;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Preferences::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Preferences::class)
            ->assertStatus(200);
    });

    it('loads user preferences on mount', function (): void {
        $this->user->settings(['theme' => 'dark', 'locale' => 'en']);

        $component = Livewire::test(Preferences::class);

        expect($component->get('theme'))->toBe('dark')
            ->and($component->get('locale'))->toBe('en');
    });

    it('user can update theme preference', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'dark')
            ->set('locale', 'fr')
            ->call('save')
            ->assertHasNoErrors();

        $this->user->refresh();

        expect($this->user->setting('theme', 'light'))->toBe('dark');
    });

    it('user can update locale preference', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'light')
            ->set('locale', 'en')
            ->call('save')
            ->assertHasNoErrors();

        $this->user->refresh();

        expect($this->user->setting('locale', 'fr'))->toBe('en');
    });

    it('validates theme is required', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', '')
            ->set('locale', 'fr')
            ->call('save')
            ->assertHasErrors(['theme' => 'required']);
    });

    it('validates locale is required', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'light')
            ->set('locale', '')
            ->call('save')
            ->assertHasErrors(['locale' => 'required']);
    });

    it('validates theme is valid option', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'invalid')
            ->set('locale', 'fr')
            ->call('save')
            ->assertHasErrors(['theme' => 'in']);
    });

    it('validates locale is valid option', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'light')
            ->set('locale', 'es')
            ->call('save')
            ->assertHasErrors(['locale' => 'in']);
    });

    it('dispatches theme-changed event', function (): void {
        Livewire::test(Preferences::class)
            ->set('theme', 'dark')
            ->set('locale', 'fr')
            ->call('save')
            ->assertDispatched('theme-changed');
    });

    it('uses default values when user has no settings', function (): void {
        $newUser = User::factory()->create();
        $this->actingAs($newUser);

        $component = Livewire::test(Preferences::class);

        expect($component->get('theme'))->toBe('light')
            ->and($component->get('locale'))->toBe(config('app.locale'));
    });
});
