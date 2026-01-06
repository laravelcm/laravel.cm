<?php

declare(strict_types=1);

use App\Models\User;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\PointType;
use Laravelcm\Gamify\Tests\Fixtures;

/**
 * @var Tests\TestCase $this
 */
beforeEach(function (): void {
    $this->user = $this->createUser();
});

describe(PointType::class, function (): void {
    it('sets point type name from class name', function (): void {
        $point = new Fixtures\FakeCreatePostPoint($this->user);

        expect($point->getName())->toBe('FakeCreatePostPoint');
    });

    it('uses name property for point name if provided', function (): void {
        $point = new Fixtures\FakeWelcomeUserWithNamePoint($this->user);

        expect($point->getName())->toBe('FakeName');
    });

    it('can get points for a point type', function (): void {
        $point = new Fixtures\FakeCreatePostPoint($this->user);

        expect($point->getPoints())->toBe(10);
    });

    it('gives point to a user', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new Fixtures\FakeCreatePostPoint($post, $this->user));

        expect($this->user->getPoints())->toBe(10)
            ->and($this->user->reputations)->toHaveCount(1);
    });

    it('can access a reputation payee and subject', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new Fixtures\FakeCreatePostPoint($post, $this->user));

        $point = $this->user->reputations()->first();

        expect($point->payee)->toBeInstanceOf(User::class)
            ->and($point->subject)->toBeInstanceOf($post::class)
            ->and($point->name)->toBe('FakeCreatePostPoint');
    });

    it('do not give point if qualifier returns false', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new Fixtures\FakeWelcomeUserWithFalseQualifier($post->user));

        expect($this->user->fresh()->getPoints())->toBe(0);
    });

    it('throws exception if no payee is returned', function (): void {
        $this->user->givePoint(new Fixtures\FakePointTypeWithoutPayee);

        expect($this->user->fresh()->getPoints())->toBe(0);
    })
        ->throws(InvalidPayeeModelException::class);

    it('throws exception if no subject is set', function (): void {
        $this->user->givePoint(new Fixtures\FakePointTypeWithoutSubject);

        expect($this->user->getPoints())->toBe(0)
            ->and($this->user->reputations)->toHaveCount(0);
    })
        ->throws(PointSubjectNotSetException::class);

    it('throws exception if no points field or method is defined', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new Fixtures\FakePointWithoutPoint($post));

        expect($this->user->getPoint())->toBe(0);
    })
        ->throws(PointsNotDefinedException::class);

    it('gives and undo point via helper functions', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        givePoint(new Fixtures\FakePayeeFieldPoint($post), $this->user);

        expect($this->user->fresh()->getPoints())->toBe(10);

        undoPoint(new Fixtures\FakePayeeFieldPoint($post), $this->user);

        $this->user->fresh();
        expect($this->user->fresh()->getPoints())->toBe(0);
    });

    it('can safely undo points that were never given', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        expect($this->user->fresh()->getPoints())->toBe(0);

        undoPoint(new Fixtures\FakePayeeFieldPoint($post), $this->user);

        expect($this->user->fresh()->getPoints())->toBe(0)
            ->and($this->user->reputations)->toHaveCount(0);
    });
});
