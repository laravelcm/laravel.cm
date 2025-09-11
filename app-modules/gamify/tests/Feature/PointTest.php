<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\Exceptions\InvalidPayeeModelException;
use Laravelcm\Gamify\Exceptions\PointsNotDefinedException;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\PointType;

final class FakeCreatePostPoint extends PointType
{
    public int $points = 10;

    public ?User $author;

    public function __construct(mixed $subject, ?User $author = null)
    {
        $this->subject = $subject;
        $this->author = $author;
    }

    public function payee(): ?User
    {
        return $this->author;
    }
}

final class FakeWelcomeUserWithNamePoint extends PointType
{
    public int $points = 30;

    public string $name = 'FakeName';

    public function __construct(mixed $subject, public ?User $author = null) {}

    public function payee(): ?User
    {
        return $this->author;
    }
}

final class FakePointTypeWithoutSubject extends PointType
{
    protected int $point = 12;

    public function __construct($subject = null)
    {
        $this->subject = $subject;
    }

    public function payee(): ?User
    {
        return new User;
    }
}

final class FakePointTypeWithoutPayee extends PointType
{
    protected int $point = 24;

    public function __construct(mixed $subject = null)
    {
        $this->subject = $subject;
    }
}

final class FakePointWithoutPoint extends PointType
{
    protected string $payee = 'user';

    public function __construct($subject = null)
    {
        $this->subject = $subject;
    }
}

final class FakeWelcomeUserWithFalseQualifier extends PointType
{
    protected int $points = 10;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function qualifier(): bool
    {
        return false;
    }

    public function payee(): ?User
    {
        return $this->getSubject()->user;
    }
}

final class FakePayeeFieldPoint extends PointType
{
    protected int $points = 10;

    /** @var string payee model relation on subject */
    protected string $payee = 'user';

    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}

beforeEach(function (): void {
    $this->user = $this->createUser();
});

describe(PointType::class, function (): void {
    it('sets point type name from class name', function (): void {
        $point = new FakeCreatePostPoint($this->user);

        expect($point->getName())->toBe('FakeCreatePostPoint');
    });

    it('uses name property for point name if provided', function (): void {
        $point = new FakeWelcomeUserWithNamePoint($this->user);

        expect($point->getName())->toBe('FakeName');
    });

    it('can get points for a point type', function (): void {
        $point = new FakeCreatePostPoint($this->user);

        expect($point->getPoints())->toBe(10);
    });

    it('gives point to a user', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new FakeCreatePostPoint($post, $this->user));

        expect($this->user->getPoints())->toBe(10);
        expect($this->user->reputations)->toHaveCount(1);
    });

    it('can access a reputation payee and subject', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new FakeCreatePostPoint($post, $this->user));

        $point = $this->user->reputations()->first();

        expect($point->payee)->toBeInstanceOf(User::class);
        expect($point->subject)->toBeInstanceOf($post::class);
        expect($point->name)->toBe('FakeCreatePostPoint');
    });

    it('do not give point if qualifier returns false', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new FakeWelcomeUserWithFalseQualifier($post->user));

        expect($this->user->fresh()->getPoints())->toBe(0);
    });

    it('throws exception if no payee is returned', function (): void {
        $this->user->givePoint(new FakePointTypeWithoutPayee);

        expect($this->user->fresh()->getPoints())->toBe(0);
    })
        ->throws(InvalidPayeeModelException::class);

    it('throws exception if no subject is set', function (): void {
        $this->user->givePoint(new FakePointTypeWithoutSubject);

        expect($this->user->getPoints())->toBe(0);
        expect($this->user->reputations)->toHaveCount(0);
    })
        ->throws(PointSubjectNotSetException::class);

    it('throws exception if no points field or method is defined', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        $this->user->givePoint(new FakePointWithoutPoint($post));

        expect($this->user->getPoint())->toBe(0);
    })
        ->throws(PointsNotDefinedException::class)
        ->skip();

    it('gives and undo point via helper functions', function (): void {
        $post = $this->createPost(['user_id' => $this->user->id]);

        givePoint(new FakePayeeFieldPoint($post), $this->user);

        expect($this->user->fresh()->getPoints())->toBe(10);

        undoPoint(new FakePayeeFieldPoint($post), $this->user);

        $user = $this->user->fresh();
        expect($this->user->fresh()->getPoints())->toBe(0);
    });
});
