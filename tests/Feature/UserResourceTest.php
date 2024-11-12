<?php

declare(strict_types=1);

use Carbon\Carbon;
use App\Models\User;
use App\Events\UserBannedEvent;
use App\Events\UserUnbannedEvent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Filament\Resources\UserResource;
use Illuminate\Support\Facades\Notification;
use App\Filament\Resources\UserResource\Pages\ListUsers;


beforeEach(function (): void {
    Event::fake();
    Notification::fake();
    Queue::fake();
    $this->user = $this->login();
});

describe(UserResource::class, function() {
    it('only admin can ban a user and send a ban notification', function () {

        Role::create(['name' => 'user']);
        $admin = $this->user->assignRole('user');

        $user = User::factory()->create();

        // $this->actingAs($admin);

        UserResource::BanUserAction($user, 'Violation des règles de la communauté');

        $user->refresh();
    
        expect($user->banned_at)->toBeInstanceOf(Carbon::class)
            ->and($user->banned_reason)->toBe('Violation des règles de la communauté');
    
        Event::assertDispatched(UserBannedEvent::class);
    });

    it('can unban a user and send a unban notification', function () {
        Role::create(['name' => 'admin']);
        $admin = $this->user->assignRole('admin');

        $user = User::factory()->create([
            'banned_at' => now(),
            'banned_reason' => 'Violation des règles de la communauté'
        ]);

        $this->actingAs($admin);

        UserResource::UnbanUserAction($user);

        $user->refresh();
    
        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();
    
        Event::assertDispatched(UserUnbannedEvent::class);
    });

    it('prevents a banned user from logging in', function () {
        $user = User::factory()->create([
            'banned_at' => now(),
        ]);
    
        $this->actingAs($user)
            ->get('/dashboard') 
            ->assertRedirect(route('login'))  
            ->assertSessionHasErrors(['email']);
    });
});