<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravelcm\Gamify\Exceptions\PointSubjectNotSetException;
use Laravelcm\Gamify\PointType;

final class Test extends PointType
{
    /**
     * Number of points
     */
    public int $points = 20;

    /**
     * Point constructor
     */
    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }

    /**
     * User who will be received points
     *
     * @return mixed
     *
     * @throws PointSubjectNotSetException
     */
    public function payee(): Model
    {
        return $this->getSubject()->user;
    }
}
