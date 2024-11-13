<?php

use App\Models\User;
use App\Actions\User\UnBanUserAction;

describe('UnBanUserActionTest', function () {
   it('can unban user', function () {
        $user = User::factory()->create([
            'banned_at' => now(),
            'banned_reason' => 'Violation des règles de la communauté'
        ]);

        app(UnBanUserAction::class)->execute($user);

        $user->refresh();

        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();
    });
});