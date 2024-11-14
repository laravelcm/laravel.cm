<?php

use App\Models\User;
use App\Actions\User\UnBanUserAction;

describe(UnBanUserAction::class, function (): void {
   it('can unban user', function () {
        $user = User::factory()->banned()->create();

        app(UnBanUserAction::class)->execute($user);

        $user->refresh();

        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();
    });
});