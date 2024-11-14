<?php

declare(strict_types=1);

use App\Actions\User\BanUserAction;
use App\Actions\User\UnBanUserAction;
use App\Events\UserBannedEvent;
use App\Events\UserUnbannedEvent;
use App\Exceptions\UserAlreadyBannedException;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\get;

beforeEach(function (): void {
    Event::fake();
    $this->user = User::factory(['email' => 'user@laravel.cm'])->create();
    Role::create(['name' => 'admin']);
    $this->user->assignRole(['admin']);
    $this->actingAs($this->user, 'web');
});

describe(UserResource::class, function (): void {
    it('can render admin page', function (): void {
        get(UserResource::getUrl())->assertSuccessful();
    })->skip();

    it('only admin can ban a user and send a ban notification', function (): void {
        $user = User::factory()->unbanned()->create();

        Livewire::test(ListUsers::class)
            ->assertSuccessful();

        expect(Gate::allows('ban', $this->user))->toBeTrue();

        app(BanUserAction::class)->execute($user, 'Violation des règles de la communauté');

        $user->refresh();

        expect($user->banned_at)->toBeInstanceOf(Carbon::class)
            ->and($user->banned_reason)->toBe('Violation des règles de la communauté');

        Event::assertDispatched(UserBannedEvent::class);
    });

    it('can unban a user and send a unban notification', function (): void {
        $user = User::factory()->banned()->create();

        Livewire::test(ListUsers::class)
            ->assertSuccessful();

        expect(Gate::allows('unban', $this->user))->toBeTrue();

        app(UnBanUserAction::class)->execute($user);

        $user->refresh();

        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();

        Event::assertDispatched(UserUnbannedEvent::class);
    });

    it('does not ban an already banned user', function (): void {
        $user = User::factory()->banned()->create();

        Livewire::test(ListUsers::class)
            ->assertSuccessful();

        $this->expectException(UserAlreadyBannedException::class);

        app(BanUserAction::class)->execute($user, 'Violation des règles');

        expect($user->banned_reason)->not->toBe('Violation des règles')
            ->and($user->banned_at)->not->toBeNull();
    });

    it('prevents a banned user from logging in', function (): void {
        $user = User::factory()->banned()->create();

        Livewire::test(ListUsers::class)
            ->assertSuccessful();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email']);

        $this->assertGuest();
    });
})->group('users');
