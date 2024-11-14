<?php

declare(strict_types=1);

use App\Actions\User\UnBanUserAction;
use App\Models\User;

describe(UnBanUserAction::class, function (): void {
    it('can unban user', function (): void {
        $user = User::factory()->banned()->create();

        app(UnBanUserAction::class)->execute($user);

        $user->refresh();

        expect($user->banned_at)->toBeNull()
            ->and($user->banned_reason)->toBeNull();
    });
});
