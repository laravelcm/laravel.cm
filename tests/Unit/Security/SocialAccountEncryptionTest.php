<?php

declare(strict_types=1);

use App\Models\SocialAccount;

uses(Tests\TestCase::class);

it('casts the OAuth token as encrypted', function (): void {
    $account = new SocialAccount;

    expect($account->getCasts())
        ->toHaveKey('token')
        ->and($account->getCasts()['token'])->toBe('encrypted');
});
