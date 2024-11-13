<?php

declare(strict_types=1);

use Carbon\Carbon;
use App\Models\User;
use function Pest\Laravel\get;
use App\Events\UserBannedEvent;
use App\Events\UserUnbannedEvent;
use Spatie\Permission\Models\Role;
use App\Actions\User\BanUserAction;
use App\Actions\User\UnBanUserAction;
use Illuminate\Support\Facades\Event;
use App\Filament\Resources\UserResource;
use App\Exceptions\UserAlreadyBannedException;

beforeEach(function (): void {
    Event::fake();
    $this->user = User::factory(['email' => 'user@laravel.cm'])->create();
    Role::create(['name' => 'admin']);
    $this->user->assignRole(['admin']);
    $this->actingAs($this->user, 'web');
});

describe(UserResource::class, function() {
    it('can render admin page', function (): void {
        get(UserResource::getUrl())->assertSuccessful();
    })->skip();

    it('only admin can ban a user and send a ban notification', function () {
        // $this->get('/cp')->assertSuccessful();

        $user = User::factory()->create();

        app(BanUserAction::class)->execute($user, 'Violation des règles de la communauté');

        $user->refresh();
    
        expect($user->banned_at)->toBeInstanceOf(Carbon::class)
            ->and($user->banned_reason)->toBe('Violation des règles de la communauté');
    
        Event::assertDispatched(UserBannedEvent::class);
    });

    it('can unban a user and send a unban notification', function () {
        // $this->get('/cp')->assertSuccessful();
        
        $user = User::factory()->create([
            'banned_at' => now(),
            'banned_reason' => 'Violation des règles de la communauté'
        ]);

        app(UnBanUserAction::class)->execute($user);

        $user->refresh();
    
        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();
    
        Event::assertDispatched(UserUnbannedEvent::class);
    });

    it('does not ban an already banned user', function () {
        // $this->get('/cp')->assertSuccessful();
        
        $user = User::factory()->create(['banned_at' => now()]);

        $this->expectException(UserAlreadyBannedException::class);
        
        app(BanUserAction::class)->execute($user, 'Violation des règles');

        expect($user->banned_reason)->not->toBe('Violation des règles')
            ->and($user->banned_at)->not->toBeNull();
    });

    it('prevents a banned user from logging in', function () {
        $user = User::factory()->create([
            'banned_at' => now(),
        ]);
    
        $this->actingAs($user)
            ->get('/dashboard') 
            ->assertRedirect(route('login'))  
            ->assertSessionHasErrors(['email']);
        
        $this->assertGuest();
    });
})->group('users');