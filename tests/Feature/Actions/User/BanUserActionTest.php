<?php

declare(strict_types=1);

use App\Actions\User\BanUserAction;
use App\Models\User;
use Carbon\Carbon;

describe(BanUserAction::class, function (): void {
    it('can ban user', function (): void {
        $user = User::factory()->unbanned()->create();

        app(BanUserAction::class)->execute($user, 'Violation des règles de la communauté');

        $user->refresh();

        expect($user->banned_at)->toBeInstanceOf(Carbon::class)
            ->and($user->banned_reason)->not->toBeNull();
    });
});
