<?php

use Carbon\Carbon;
use App\Models\User;
use App\Actions\User\BanUserAction;

describe(BanUserAction::class, function (): void {
    it('can ban user', function () {
        $user = User::factory()->unbanned()->create();;

        app(BanUserAction::class)->execute($user, 'Violation des règles de la communauté');

        $user->refresh();
    
        expect($user->banned_at)->toBeInstanceOf(Carbon::class)
            ->and($user->banned_reason)->not->toBeNull();
    });
});