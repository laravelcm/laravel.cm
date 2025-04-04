<?php

declare(strict_types=1);

use Laravelcm\Gamify\Models\Reputation;

describe(Reputation::class, function (): void {

    it('gets user points', function (): void {
        $user = $this->createUser(['reputation' => 10]);

        expect($user->getPoints())->toBe(10);
    });

    it('gives reputation point to a user', function (): void {
        $user = $this->createUser();

        expect($user->getPoints())->toBe(0);

        $user->addPoint(10);

        expect($user->fresh()->getPoints())->toBe(10);
    });

    it('reduces reputation point for a user', function (): void {
        $user = $this->createUser(['reputation' => 20]);

        expect($user->reputation)->toBe(20);

        $user->reducePoint(5);

        expect($user->fresh()->getPoints())->toBe(15);
    });

    it('zeros reputation point of a user', function (): void {
        $user = $this->createUser(['reputation' => 50]);

        expect($user->getPoints())->toBe(50);

        $user->resetPoint();

        expect($user->fresh()->getPoints())->toBe(0);
    });
});
